@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('user_view',$user->id) }}
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

                    <form name="user" method="post" action="">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Salutation</label>
                                        <input type="text" class="form-control" value="{{$user->salutation}}"
                                               readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">First Name</label>
                                        <input class="form-control" placeholder="" value="{{ $user->firstname }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Last Name</label>
                                        <input class="form-control" placeholder="" value="{{ $user->lastname }}"
                                               name=""
                                               type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Email</label>
                                        <input class="form-control " placeholder="" value="{{ $user->email }}"
                                               name="" type="text" id="" readonly="readonly">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Member Type</label>
                                        <input class="form-control " placeholder=""
                                               value="{{ memberType($user->member_type) }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Organisation</label>
                                        <input class="form-control" placeholder="" value="{{ $user->organization }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Job Title</label>
                                        <input class="form-control " placeholder="" value="{{ $user->job_title }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Telephone Number</label>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <input class="form-control" placeholder=""
                                                       value=" +{{ $user->telephone_code }}"
                                                       name="" type="text" id="" readonly="readonly">
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control" placeholder=""
                                                       value="{{ $user->telephone_number }}"
                                                       name="" type="text" id="payee_name" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Mobile Number</label>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <input class="form-control" placeholder=""
                                                       value=" +{{ $user->mobile_code }}"
                                                       name="" type="text" id="" readonly="readonly">

                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control" placeholder=""
                                                       value="{{ $user->mobile_number }}"
                                                       name="" type="text" id="mobile_number" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Country</label>
                                        <input class="form-control " placeholder="" value="{{ $user->country}}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">City</label>
                                        <input class="form-control " placeholder="" value="{{ $user->city }}"
                                               name="" type="text" id="" readonly="readonly">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Address line 1</label>
                                        <input class="form-control " placeholder="" value="{{ $user->address1 }}"
                                               name="" type="text" id="" readonly>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Address line 2</label>
                                        <input class="form-control " placeholder="" value="{{ $user->address2 }}"
                                               name="" type="text" id="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $groups = memberGroupByUserIds($user->id);
                                    $groupNames = $groups->pluck('group_name')->all();
                                    ?>
                                    <div class="form-group">
                                        <label for="" class=" control-label">Group</label>
                                        <input class="form-control " placeholder="" value="{{implode(',',$groupNames)}}"
                                               name="" type="text" id="" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="" class=" control-label">Registration Date</label>
                                        <input class="form-control " placeholder=""
                                               value="{{ $user->created_at->format('d M, Y H:i A') ?? '-' }}"
                                               name="" type="text" id="" readonly>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Subscription Date</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($user->invoice()) )
                                               {{ $user->invoice()->created_at->format('d M, Y')}}
                                               @else - @endif" name="" type="text" id="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address2" class=" control-label">Renewal Date</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($user->invoice()) && $user->invoice()->period_type=='Month' )
                                               {{date('d M, Y', strtotime("+".$user->invoice()->period_value." months", strtotime($user->invoice()->created_at)))}}
                                               @elseif(!is_null($user->invoice()) && $user->invoice()->period_type=='Year')
                                               {{date('d M, Y', strtotime("+".$user->invoice()->period_value." years", strtotime($user->invoice()->created_at)))}}
                                               @else - @endif"
                                               name="address2" type="text" id="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="" class=" control-label">Payment Status</label>
                                        <input class="form-control " placeholder=""
                                               value="@if(!is_null($user->invoice()) && $user->invoice()->paid==1 )
                                                       Paid @elseif(!is_null($user->invoice()) && $user->invoice()->paid==0)
                                                       Unpaid @else - @endif"
                                               name="" type="text" id="" readonly>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class=" control-label">Subscription Status</label>
                                        <input class="form-control " placeholder=""
                                               value="@if($user->status==5)Active @else Inactive @endif" name=""
                                               type="text" id="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address2" class=" control-label">Overall Status</label>
                                        <input class="form-control " placeholder=""
                                               value="{{memberShipStatus($user->status)}}"
                                               name="address2" type="text" id="" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->


                        </div>
                    </form>
                    <!-- /.box -->
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transaction History</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="" data-original-title="Collapse">
                                <i class="fa fa-minus"></i></button>

                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="payments" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Payer Email</th>
                                <th>Order Id</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                                <th>Currency</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php $payments = userPayments($user->id); ?>
                            @if($payments->count())
                                @foreach($payments as $key => $payment)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{ $payment->user_email ?? '-' }}</td>
                                        <td>{{ $payment->order_id ?? '-' }}</td>
                                        <td data-order="<?php if (!is_null($payment->created_at)) {
                                            echo $payment->created_at->format('d M, Y H:i:s');
                                        }?>">@if(!is_null($payment->created_at) )
                                                {{ $payment->created_at->format('d M, Y')}}
                                            @else - @endif
                                        </td>
                                        <td>
                                            {{$payment->total}}
                                        </td>
                                        <td>{{$payment->currency}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>

                        </table>

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
