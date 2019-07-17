@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('payment_view',$payment->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->

                    <form name="" method="post" action="">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Payment Id</label>
                                        <input type="text" class="form-control" value="{{$payment->order_id}}"
                                               readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Payee Name</label>
                                        <input class="form-control" placeholder=""
                                               value="{{ $payment->user()->firstname.' '.$payment->user()->lastname }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Payee Email</label>
                                        <input class="form-control" placeholder=""
                                               value="{{ $payment->user_email ?? '-' }}"
                                               name=""
                                               type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Payment Date</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($payment->created_at) ) {{ $payment->created_at->format('d M, Y')}} @else - @endif"
                                               name="" type="text" id="" readonly="readonly">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Subscription Date</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($payment->created_at) ) {{ $payment->created_at->format('d M, Y')}} @else - @endif"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Renewal Date</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($payment->period_type) && $payment->period_type=='Month' ) {{date('d M, Y', strtotime("+".$payment->period_value." months", strtotime($payment->created_at)))}} @elseif(!is_null($payment->period_type) && $payment->period_type=='Year') {{date('d M, Y', strtotime("+".$payment->period_value." years", strtotime($payment->created_at)))}} @else - @endif"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="control-label">Subscription Status</label>
                                        <input class="form-control" placeholder=""
                                               value="@if($payment->user()->status==5)Active @else Inactive @endif"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Payment Mode</label>
                                        <input class="form-control " placeholder=""
                                               value="{{ $payment->subscription_type ?? '-' }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Status</label>
                                        <input class="form-control " placeholder="" value="@if($payment->paid==1)Paid  @else Unpaid @endif"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="">
                                <a href="{{url('admin/payment')}}"  class="btn btn-primary ">Back</a>
                            </div>
                            <!-- /.box-footer-->
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('header-script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
@endpush
@push('scripts')
<script>
    $('#payments').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[3, 'asc']],
                "aoColumnDefs": [{
                    "aTargets": [],
                    "bSortable": false
                },
                    {width: 100, targets: 0},
                    {width: 150, targets: 1},
                    {width: 300, targets: 2},
                    {width: 150, targets: 3},
                    {width: 150, targets: 4},
                    {width: 150, targets: 5}

                ]
            });
</script>
@endpush
