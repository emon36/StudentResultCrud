@extends('master.admin.master')
@section('body')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Student</h4>
                    <p class="text-center text-success">{{Session::get('message')}}</p>
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover mb-0">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Image</th>
                                <th>Total Marks</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->name}}</td>
                    <td> <img src="{{asset('uploads/studentFiles/'.$student->image)}}" width="100"></td>
                    <td>{{$student->getStudentResult($student->id)}}</td>
                    <td>

                        <a href="{{route('admin.student.show',$student->id)}}}" class="btn btn-success btn-group-sm"> view </a>
                        <a href="{{route('admin.student.edit',$student->id)}}" class="btn btn-info btn-group-sm"> Edit </a>
                        <a href="javascript:void(0)" data-id="{{$student->id}}" class="btn btn-danger btn-group-sm deleteStudent"> Delete </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {!! $students->links('pagination::bootstrap-4') !!}
            </div>

        </div>

    </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.deleteStudent', function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.student.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                console.log(response);
                                Swal.fire(
                                    'Deleted!',
                                    'Customer has been deleted.',
                                    'success'
                                )
                                location.reload();
                            }
                        });
                    }
                });

            });



        });
    </script>
@endsection
