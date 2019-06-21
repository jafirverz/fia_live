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
                        <a href="{{ url('admin/payment/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>
                    <form id="payment_search" action="{{ url('admin/payment/date-range-search') }}" method="post">
        @csrf
                    <div class="box-header with-border">
                            <div class="input-group pull-right">
                                <label for="inputEmail3" class="col-sm-4 control-label">Date Range</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="daterange" value="@if(isset($daterange_old)) {{ $daterange_old }} @endif"/>
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
                                <th>Payment Id	</th>
                                <th>Payment Date	</th>
                                <th>Subscription Date</th>
                                <th>Subscription Status</th>
                                <th>Renewal Date</th>
                                <th>Payee Email Id</th>
                                <th>Payee Name</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($payments->count())
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            @if($payment->id)
                                                {{ $payment->id   }}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->payment_id	)
                                                {{ $payment->payment_id}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>

                                        <td>
                                            @if($payment->payment_date)
                                                {{ $payment->payment_date}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->subscription_date)
                                                {{ $payment->subscription_date}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->subscription_status==1)
                                                Active
                                            @else
                                                DeActive
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->renewal_date)
                                                {{ $payment->renewal_date}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->payee_email_id)
                                                {{ $payment->payee_email_id}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->payee_name)
                                                {{ $payment->payee_name}}
                                            @else
                                                {{NONE}}
                                            @endif
                                        </td>
                                        
                                         <td>
                                            @if($payment->payment_mode==1)
                                                Online
                                            @else
                                                Offline
                                            @endif
                                        </td>
                                       <td>
                                            @if($payment->status==1)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment->created_at == null)
                                                {{$payment->created_at}}
                                            @endif
                                            {!!  date("Y-m-d H:i:s", strtotime($payment->created_at))   !!}

                                        </td>
                                        <td>@if ($payment->updated_at == null)
                                                {{$payment->updated_at}}
                                            @endif
                                            {!!  date("Y-m-d H:i:s", strtotime($payment->updated_at))   !!}

                                        </td>
                                        <td>
                                            <a href="{{ url('admin/payment/edit/' . $payment->id) }}"
                                               title="Edit Filter">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('admin/payment/destroy/' . $payment->id) }}"
                                               title="Destroy Filter"
                                               onclick="return confirm('Are you sure you want to delete this payment?');">
                                                <i class="fa fa-trash btn btn-danger" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Payment Id	</th>
                                <th>Payment Date	</th>
                                <th>Subscription Date</th>
                                <th>Subscription Status</th>
                                <th>Renewal Date</th>
                                <th>Payee Email Id</th>
                                <th>Payee Name</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated on</th>
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
				{
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
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
		
		 $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $("#payment_search").submit();
        });
        /*$('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $("#orders").submit();
        });
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');*/

    });
</script>
@endsection
