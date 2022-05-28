<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::orderBy('id','desc')->paginate('5');
        return view('admin.student.index',['students'=>$student]);
    }

    public function create(){

        $subjects = Subject::all();

        return view('admin.student.create',['subjects'=>$subjects]);

    }



    public function store(Request $request)
    {

        $imageFileName = 'studentImage.png';
        if ($request->hasFile('image')) {
            $studentImageFile = $request->file('image');
            $imageFileName = 'student_' . time() . '.' . $studentImageFile->getClientOriginalExtension();
            if (!file_exists('uploads/studentFiles')) {
                mkdir('uploads/studentFiles', 0777, true);
            }
            $studentImageFile->move('uploads/studentFiles', $imageFileName);

        }
        $student = new Student();
        $student->name = $request->name;
        $student->image = $imageFileName;
        $student->save();

        return back()->with('message', 'Your form has been submitted.');

    }

    public function show($id)
    {
        $student = Student::find($id);
        $result = StudentResult::where('student_id',$id)->get();
        return view('admin.student.show',['student'=>$student,'result'=>$result]);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $subjects = Subject::all();

        return view('admin.student.edit',['student'=>$student,'subjects'=>$subjects]);

    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $student = Student::find($id);
            $student->name = $request->name;

            if ($request->file('image')) {
                $destination = 'uploads/studentFiles/' . $student->image;
                if (file_exists($destination)) {
                    @unlink($destination);
                }
                $studentImageFile = $request->file('image');
                $imageFileName = 'profile_' . time() . '.' . $studentImageFile->getClientOriginalExtension();
                $studentImageFile->move('uploads/studentFiles/', $imageFileName);
                $student->image = $imageFileName;
            }
            $student->update();

            if ($request->has('addmore')) {
                $collection = $request->addmore;
                foreach ($collection as $key => $value) {
                    if (StudentResult::where('subject_id', $value['subject_id'])->where('student_id',$student->id)->exists()) {
                        $result = StudentResult::find($student->id);
                        $result->update([
                            '$student->id'=>$student->id,
                            'subject_id' => $value['subject_id'],
                            'achieve_number' => $value['achieve_number'],
                        ]);
                    } else {
                        $result = new StudentResult();
                        $result->student_id = $student->id;
                        $result->subject_id = $value['subject_id'];
                        $result->achieve_number = $value['achieve_number'];
                        $result->save();
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.students')->with('message', 'Student Information has been Updated.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

}


    public function delete(Request $request)
    {

        $id = $request->id;
        $student = Student::find($id);
        $imagePath = public_path("/uploads/StudentFiles/".$student->image);
        if (file_exists($imagePath))
        {
            @unlink($imagePath);
        }else{
            $student->delete();
        }
        $student->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Student Deleted Successfully.'
        ]);

    }


}
