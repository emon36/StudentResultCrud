@extends('master.admin.master')
@section('body')

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <form action="{{route('admin.student.update',$student->id)}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Student Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" value="{{$student->name}}"
                                   id="horizontal-firstname-input">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Student Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" class="form-control" id="horizontal-firstname-input">
                            <br>
                            <img src="{{asset('uploads/studentFiles/'.$student->image)}}" width="100">
                        </div>
                    </div>

                    <table class="table table-bordered" id="dynamicTable">
                        <tr>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Action</th>

                        </tr>
                        <tr>
                            <td><select class="form-control m-bootstrap-select" name="addmore[0][subject_id]">
                                    <option value=""> Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}">
                                            {{ $subject->subject_name}}
                                        </option>@endforeach</select>
                            </td>

                            <td><input type="text" name="addmore[0][achieve_number]" placeholder="Enter Marks"
                                       class="form-control"/></td>
                            <td>
                                <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                            </td>

                        </tr>

                    </table>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" id="btn-save" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var i = 0;
        $("#add").click(function () {
            ++i;
            $("#dynamicTable").append('<tr><td><select class="form-control m-bootstrap-select" name="addmore[' + i + '][subject_id]"><option value="">Select Subject</option>@foreach($subjects as $subject)<option value="{{$subject->id}}">{{ $subject->subject_name}}</option>@endforeach</select></td> <td><input type="text" name="addmore[' + i + '][achieve_number]" placeholder="Enter Marks" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });

    </script>
@endsection

