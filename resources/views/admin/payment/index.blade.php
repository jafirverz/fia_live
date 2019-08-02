@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('payment') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                        
                    </div>
                    <form id="payment_search" action="{{ url('admin/payment/date-range-search') }}" method="post">
                        @csrf
                        <div class="box-header with-border">
                            <div class="input-group pull-right">
                                <label for="inputEmail3" class="col-sm-4 control-label">Date Range</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="daterange"
                                           value="@if(isset($daterange_old)) {{ $daterange_old }} @endif"/>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="datatable_payment" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Payment Id</th>
                                <th>Payment Date</th>
                                <th>Subscription Date</th>
                                <th>Subscription Status</th>
                                <th>Renewal Date</th>
                                <th>Payee Email Id</th>
                                <th>Payee Name</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($payments->count())
                                @foreach($payments as $key=>$payment)
                                    <tr>
                                        <td>
                                            {{$key+1}}
                                        </td>
                                        <td>
                                            @if($payment->order_id)
                                                {{ $payment->order_id}}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td data-order="<?php if (!is_null($payment->created_at)) {
                                            echo $payment->created_at->format('d M, Y H:i:s');
                                        }?>">@if(!is_null($payment->created_at) )
                                                {{ $payment->created_at->format('d M, Y')}}
                                            @else - @endif
                                        </td>
                                        <td>@if(!is_null($payment->created_at) )
                                                {{ $payment->created_at->format('d M, Y')}}
                                            @else - @endif
                                        </td>
                                        <td>@if($payment->user()->status==5)Active @else Inactive @endif</td>
                                        <td>
                                            @if(!is_null($payment->period_type) && $payment->period_type=='Month' )
                                                {{date('d M, Y', strtotime("+".$payment->period_value." months", strtotime($payment->created_at)))}}
                                            @elseif(!is_null($payment->period_type) && $payment->period_type=='Year')
                                                {{date('d M, Y', strtotime("+".$payment->period_value." years", strtotime($payment->created_at)))}}
                                            @else - @endif
                                        </td>
                                        <td>{{ $payment->user_email ?? '-' }}</td>
                                        <td>{{ $payment->user()->firstname.' '.$payment->user()->lastname }}</td>
                                        <td>{{ $payment->subscription_type ?? '-' }}</td>
                                        <td>
                                            @if($payment->paid==1)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>

                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a class="" title="View Payment detail"
                                                           href="{{ url('admin/payment/view/' . $payment->id) }}">
                                                            <i class="fa fa-eye btn btn-success"> View</i>
                                                        </a>
                                                    </td>
                                                    @if(!is_null($payment->path))
                                                        <td>
                                                            <a class="" title="Download Invoice" target="_blank"
                                                               href="{{ asset('storage/'.$payment->path) }}">
                                                                <i class="fa fa-download btn btn-primary"> Download</i>
                                                            </a>
                                                        </td>
                                                    @endif
                                                    {{--<td>
                                                        <a class="" title="Delete User"
                                                           onclick="return confirm('Are you sure to delete this user?')"
                                                           href="{{ url('admin/user/destroy/' . $user->id) }}">
                                                            <i class="fa fa-trash btn btn-danger"> Delete</i>
                                                        </a>
                                                    </td>--}}
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Payment Id</th>
                                <th>Payment Date</th>
                                <th>Subscription Date</th>
                                <th>Subscription Status</th>
                                <th>Renewal Date</th>
                                <th>Payee Email Id</th>
                                <th>Payee Name</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
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

        $('#datatable_payment').DataTable({
            dom: 'Bfrtip',
            buttons: [

                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }

                }
            ]
        });


        $('#datatable_payment tfoot th').each(function (i) {
            if (i == 1 || i == 6 || i == 7) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            }
        });

        // DataTable
        var table = $('#datatable_payment').DataTable();

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });
        });

        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $("#payment_search").submit();
        });
        /*$('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
         $("#orders").submit();
         });
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');*/

    });
</script>
@endsection
