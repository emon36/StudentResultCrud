<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentResult;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::orderBy('id','desc')->paginate('10');
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

        return redirect()->back();

    }

    public function edit($id)
    {
        $student = Student::find($id);
        $subjects = Subject::all();

        return view('admin.student.edit',['student'=>$student,'subjects'=>$subjects]);

    }

    public function update(Request $request,$id)
    {
        $student = Student::find($id);
        $student->name = $request->name;

        if($request->file('image'))
        {
            $destination = 'uploads/studentFiles/'.$student->image;
            if(file_exists($destination))
            {
                @unlink($destination);
            }
            $studentImageFile = $request->file('image');
            $imageFileName = 'profile_' . time() . '.' . $studentImageFile->getClientOriginalExtension();
            $studentImageFile->move('uploads/studentFiles/', $imageFileName);
            $student->image = $imageFileName;
        }
        $student->update();

        if ($request->subject_id or $request->achieve_number)
        {

            $result =  new StudentResult();
            $result->student_id = $id;
            $result->subject_id = $request->subject_id;
            $result->achieve_number = $request->achieve_number;

            $result->save();
        }

        return redirect()->back();

    }




}
