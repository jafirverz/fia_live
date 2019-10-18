@extends('admin.layout.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>{{ $subtitle }}</small>
        </h1>
        {{ Breadcrumbs::render('contactenquiry') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <div class="box-header with-border">
                        <a  class="hide delete bulk_remove btn btn-primary pull-left"><span class="badge"></span> Delete selected Enquiries</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_remove_contact_enquiry">
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                               <table class="table table-bordered table-hover " id="enquiry">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                            <th>Contact Name</th>
                                            <th>Email</th>
                                            <th>Enquiry Type</th>
                                            <th>Message</th>
                                            <th>Type</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($contact_enquiry)
                                        @foreach ($contact_enquiry as $item)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="bluk_remove[]" value="{{ $item->id }}">
                                            </td>
                                            <td>{{ ucwords($item->name) }}</td>
                                            <td>{{ $item->emailid }}</td>
                                            <td>{{ $item->enquiry_type }}</td>
                                            <td>{{ $item->message }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td data-order="{{ $item->created_at }}">{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                            <td data-order="{{ $item->updated_at }}">{{ $item->updated_at->format('d M, Y h:i A') }}</td>
                                         </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#enquiry').dataTable({
            'order': [6, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5,6]
                    },
                    filename: function () {
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!
                        var yyyy = today.getFullYear();
                        var yy = yyyy.toString().substring(2);
                        if (dd < 10) {
                            dd = '0' + dd
                        }
                        if (mm < 10) {
                            mm = '0' + mm
                        }
                        today = yy + '' + mm + '' + dd;
                        return 'Contact Enquiry - ' + today;
                    }
                }
            ]
        });

        var bulk_arr = [];
        var bulk_arr1 = [];
        $("select[name='select_type']").on("change", function () {
            var select_type = $(this).val();
            var type = $("input[name='bulk_remove_type']").val();
            if (select_type != '') {
                var r = confirm("Are you sure?");
                if (r == true) {
                    $.post("{{ route('user-bulk-remove') }}", {
                        id: bulk_arr1,
                        type: type,
                        select_type: select_type,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        if (data.trim() == 'success') {
                            window.location.reload();
                        }
                    });
                }
            }
        });
        $("input[name='bluk_remove[]']").on("click", function () {
            var value = $(this).val();
            $(this).each(function () {
                if ($(this).is(":checked")) {
                    bulk_arr.push(value);
                    bulk_arr1.push(value);
                    $("a.bulk_remove, div.bulk_status").removeClass("hide");
                }
                else {
                    bulk_arr.pop(value);
                    bulk_arr1.pop(value);
                }
            });
            if (bulk_arr.length < 1) {
                $("a.bulk_remove, div.bulk_status").addClass("hide");
                $("a.bluk_remove, div.bulk_status").find(".badge").text('');
            }
            else {
                $("a.bulk_remove, div.bulk_status").removeClass("hide");
                $("a.bulk_remove").find(".badge").text(bulk_arr.length);
                $("div.bulk_status").find(".badge").text(bulk_arr1.length);
            }
        });
        $("input[name='all_bulk_remove']").on("click", function () {
            bulk_arr = [];
            if ($(this).is(":checked")) {
                $("input[name='bluk_remove[]']").each(function () {
                    var value = $(this).val();
                    $(this).prop("checked", true);
                    bulk_arr.push(value);
                    bulk_arr1.push(value);
                    $("a.bulk_remove, div.bulk_status").removeClass("hide");
                });
                $("a.bulk_remove").find(".badge").text(bulk_arr.length);
                $("div.bulk_status").find(".badge").text(bulk_arr1.length);
            }
            else {
                $("input[name='bluk_remove[]").prop("checked", false);
                $("input[name='bluk_remove[]']").each(function () {
                    var value = $(this).val();
                    $(this).prop("checked", false);
                    bulk_arr.pop(value);
                    bulk_arr1.pop(value);
                    $("a.bulk_remove, div.bulk_status").addClass("hide");
                });
                $("a.bulk_remove, div.bulk_status").find(".badge").text('');
            }
        });
        $("a.bulk_remove").on("click", function () {
            var r = confirm("Are you sure?");
            var type = $("input[name='bulk_remove_type']").val();
            if (r == true) {
                $.post("{{ route('user-bulk-remove') }}", {id: bulk_arr, type: type, _token: CSRF_TOKEN}, function (data) {
                    if (data.trim() == 'success') {
                        window.location.reload();
                    }
                });
            }
        });
    });

</script>
@endsection
