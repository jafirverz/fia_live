@extends('admin.layout.app') @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('users') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>St Email</th>
                                    <th>Student ID</th>
                                    <th>Telephone</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Nationality</th>
                                    <th>Race</th>
                                    <th>Religion</th>
                                    <th>Marital Status</th>
                                    <th>NRIC/Passport No.</th>
                                    <th>Applicant Type</th>
                                    <th>Fees Paid</th>
                                    <th>Country</th>
                                    <th>Church</th>
                                    <th>Denomination</th>
                                    <th>Occupation</th>
                                    <th>Date of Student Registration</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($students->count())
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->student_name ?? '-' }}</td>
                                    <td>{{ $student->student_email ?? '-' }}</td>
                                    <td>{{ $student->student_id ?? '-' }}</td>
                                    <td>{{ $student->telephone ?? '-' }}</td>
                                    <td>@if($student->student_dob) {{ date('d M, Y', strtotime($student->student_dob)) }} @else - @endif</td>
                                    <td>@if($student->student_gender==0) Male @else Female @endif</td>
                                    <td>@if($student->student_nationality) @if($student->student_nationality=='Other') {{ $student->student_nationality_other }} @else {{ $student->student_nationality }} @endif @else - @endif</td>
                                    <td>@if($student->race) @if($student->race=='Other') {{ $student->race_other }} @else {{ $student->race }} @endif @else - @endif</td>
                                    <td>@if($student->religion) @if($student->religion=='Other') {{ $student->religion_other }} @else {{ $student->religion }} @endif @else - @endif</td>
                                    <td>@if($student->marital_status) {{ marital_status($student->marital_status) }} @else - @endif</td>
                                    <td>{{ $student->nric_passport_no ?? '-' }}</td>
                                    <td>{{ $student->applicant_type ?? '-' }}</td>
                                    <td>{{ $student->fees_paid ?? '-' }}</td>
                                    <td>{{ $student->country ?? '-' }}</td>
                                    <td>{{ $student->church ?? '-' }}</td>
                                    <td>{{ $student->denomination ?? '-' }}</td>
                                    <td>{{ $student->occupation ?? '-' }}</td>
                                    <td data-order="{{ $student->created_at }}">
                                        @if ($student->created_at == null)
                                        {{$student->created_at}}
                                        @endif
                                        {!! date("Y-m-d", strtotime($student->created_at)) !!}

                                    </td>
                                    <td>
                                        <select class="form-control" name="status" data-student-id={{$student->id}}>
                                            <option value="">-- Select --</option>
                                            @foreach(studentRegistrationApprovedStatus() as $key => $value)
                                            <option value="{{ $key }}" @if($student->registration_status==($key))
                                                selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <a class="" title="Edit Student"
                                            href="{{ url('admin/student/edit/' . $student->id) }}">
                                            <i class="fa fa-pencil btn btn-primary"></i>
                                        </a>
                                        <a class="" title="Delete student"
                                            onclick="return confirm('Are you sure to delete this student?')"
                                            href="{{ url('admin/student/destroy/' . $student->id) }}">
                                            <i class="fa fa-trash btn btn-danger"></i>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable({
            'order': [17, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel',
            ],
            "columnDefs": [{
                "targets": [18, 19],
                "orderable": false
            }],
        });

        $('#datatable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // DataTable
        var table = $('#datatable').DataTable();

        // Apply the search
        $("select[name='status']").on("change", function () {
            var r = confirm("Are you sure?");
            if (r == true) {
                var status = $(this).val();
                var s_id = $(this).data('student-id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    method: "POST",
                    url: "student/update-status",
                    data: {
                        registration_status: status,
                        s_id: s_id,
                        _token: CSRF_TOKEN
                    },
                    cache: false,
                    async: false,
                    success: function (data) {
                        alert(data);
                        if (data == "Success") {
                            alert("Status has been changed.");
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        });
    });

</script>
@endsection
