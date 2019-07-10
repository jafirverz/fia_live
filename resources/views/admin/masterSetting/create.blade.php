@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains master-setting content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('master-setting-create') }}
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
                    <form method="post" action="{{ url('/admin/master-setting/store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label for="subscription_value" class=" control-label">Subscription Charge </label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ old('subscription_value') }}" name="subscription_value" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subscription_validity" class=" control-label">Subscription Period </label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('subscription_validity') }}" name="subscription_validity" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subscription_validity_type" class=" control-label">Subscription Period Type</label>
                            <div class="">
                                <select name="subscription_validity_type" class="form-control " style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    <option value="Month" @if(old('subscription_validity_type')=='Month')Selected="selected" @endif> Month</option>
                                    <option value="Year" @if(old('subscription_validity_type')=='Year')Selected="selected" @endif> Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gst_percentage" class=" control-label">GST (%)</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('gst_percentage') }}" name="gst_percentage" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gst_no" class=" control-label">GST NO</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{  old('gst_no') }}" name="gst_no" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tax_invoice_text" class=" control-label">TAX Invoice Text</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{  old('tax_invoice_text') }}" name="tax_invoice_text" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="invoice_constant" class=" control-label">Invoice Prefix</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ old('invoice_constant') }}" name="invoice_constant" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="currency" class=" control-label">Currency</label>
                            <div class="">
                                <select name="currency" class="form-control " style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    <option value="AUD" @if(old('currency')=='AUD')Selected="selected" @endif> AUD - Australian dollar</option>
                                    <option value="SGD" @if(old('currency')=='SGD')Selected="selected" @endif> SGD - Singapore dollar</option>
                                    <option value="USD" @if(old('currency')=='USD')Selected="selected" @endif> USD - United States dollar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="invoice_series_no" class=" control-label">Invoice Series No</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('invoice_series_no') }}" name="invoice_series_no" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="invoice_footer" class=" control-label">Invoice Footer</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('invoice_footer') }}" name="invoice_footer" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="invoice_footer_address" class=" control-label">Invoice Footer Address</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('invoice_footer_address') }}" name="invoice_footer_address" type="text">
                            </div>
                        </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div>
                <!-- /.box-body -->


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
@push('scripts')
@endpush
