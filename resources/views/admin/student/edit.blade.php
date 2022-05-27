@extends('master.admin.master')
@section('body')

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <form action="{{route('admin.student.update',$student->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Student Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" value="{{$student->name}}" id="horizontal-firstname-input">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Student Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" class="form-control" id="horizontal-firstname-input">
                            <img src="{{asset('uploads/studentFiles/'.$student->image)}}" width="100">
                        </div>
                    </div>
                    <button id="addRow" type="button" class="btn btn-info float-right mb-3 ">Add Subject</button>



                    <div id="newRow"></div>


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
        >
    </div>
@endsection

@section('scripts')
    <script>
        var subjects = {!! json_encode($subjects->toArray()) !!}
        var options;

        $.each( subjects, function( key, value ) {
            options = options + '<option value="'+value.id+'">'+value.subject_name+'</option>';
        })

        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<select class="form-control" name="subject_id">';
            html += '<option>choose subject</option>';
            html +=  options;
            html += '</select>';
            html += '<input type="number" name="achieve_number" class="form-control m-input" placeholder="Enter Marks" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });

    </script>
@endsection

