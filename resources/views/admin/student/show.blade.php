@extends('master.admin.master')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Student Name</th>
                        <td>{{$student->name}}</td>
                    </tr>
                    <tr>
                        <th>Studnet Image</th>
                        <td> <img src="{{asset('uploads/studentFiles/'.$student->image)}}" width="100"></td>
                    </tr>

                    @foreach($result as $row)

                    <tr>
                        <th>Subject Name</th>

                        <td>{{$row->subject->subject_name}}</td>

                    </tr>
                    <tr>
                        <th>Marks</th>
                        <td>{{$row->achieve_number}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>Total marks</th>
                        <td>{{$student->getStudentResult($student->id)}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
