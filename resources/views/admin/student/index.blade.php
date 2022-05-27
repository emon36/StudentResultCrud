@extends('master.admin.master')
@section('body')

    <div class="col-md-12 card-header">
        <div id="success_message"></div>
        <div class="col-md-12">
            <table class="table table-bordered" id="student_table">
                <thead>
                <tr>
                    <th scope="col">Student Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{$student->name}}</td>
                    <td> <img src="{{asset('uploads/studentFiles/'.$student->image)}}" width="100"></td>
                    <td>100</td>
                    <td>

                        <a href="" class="btn btn-success btn-group-sm"> view </a>
                        <a href="{{route('admin.student.edit',$student->id)}}" class="btn btn-info btn-group-sm"> Edit </a>
                        <a href="" class="btn btn-danger btn-group-sm"> Delete </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {!! $students->links() !!}

        </div>
    </div>

@endsection
