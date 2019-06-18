@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('payment_edit', $payment->id) }}
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
                   
                     <form name="payment" method="post" action="{{ url('/admin/payment/update/'.$payment->id)}}">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="payment_id" class=" control-label">Payment Id</label>
                            
<input class="form-control" placeholder="" value="{{ guid() }}" name="payment_id" type="text" id="payment_id">                            
                           
                        </div>

                        
                        <div class="form-group">
<label for="payment_date" class=" control-label">Payment Date</label>
<input class="form-control datepicker" placeholder="" value="{{ $payment->payment_date }}" name="payment_date" type="text" id="payment_date">                            
                        </div>
                        
                        <div class="form-group">
<label for="payment_date" class=" control-label">Subscription Date</label>
<input class="form-control datepicker" placeholder="" value="{{ $payment->subscription_date }}" name="subscription_date" type="text" id="subscription_date">                            
                        </div>
                        
                        <div class="form-group">
<label for="status" class="control-label">Subscription Status</label>
                           
<select  name="subscription_status" class="form-control select2"  id="selectpicker" data-placeholder="Select Status" >
						@foreach(ActiveInActinve() as $k => $v)
                            <option value="{{$k}}"  @if($payment->status==$k) selected @endif>{{$v}}</option>
                        @endforeach                             
</select>                            
                           
                    </div>
                    
                    
                        
                        <div class="form-group">
<label for="renewal_date" class=" control-label">Renewal Date</label>
<input class="form-control datepicker" placeholder="" value="{{ $payment->renewal_date }}" name="renewal_date" type="text" id="renewal_date">                            
                        </div>
                        
                        <div class="form-group">
<label for="payee_email_id" class=" control-label">Payee Email Id</label>
<input class="form-control" placeholder="" value="{{ $payment->payee_email_id }}" name="payee_email_id" type="text" id="payee_email_id">                            
                        </div>
                        
                         <div class="form-group">
<label for="payee_name" class=" control-label">Payee Name</label>
<input class="form-control" placeholder="" value="{{ $payment->payee_name }}" name="payee_name" type="text" id="payee_name">                            
                        </div>
                        
                        <div class="form-group">
<label for="payment_mode" class="control-label">Payment Mode</label>
                           
<select  name="payment_mode" class="form-control select2"  id="selectpicker" data-placeholder="Select Status" >
						@foreach(get_payment_mode() as $k => $v)
                            <option value="{{$k}}"  @if($payment->payment_mode==$k) selected @endif>{{$v}}</option>
                        @endforeach                             
</select>                            
                           
                    </div>
                    
                    <div class="form-group">
<label for="status" class="control-label">Status</label>
                           
<select  name="status" class="form-control select2"  id="selectpicker" data-placeholder="Select Status" >
						@foreach(get_status() as $k => $v)
                            <option value="{{$k}}"  @if($payment->status==$k) selected @endif>{{$v}}</option>
                        @endforeach                             
</select>                            
                           
                    </div>
                    <!-- /.box-body -->

                    
                    
                </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
