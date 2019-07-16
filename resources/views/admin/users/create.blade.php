@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('user_create') }}
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

                    <form name="user" method="post" action="{{ url('/admin/user/store')}}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="salutation" class=" control-label">Salutation</label>
                                <select class="select2 form-control" name="salutation">
                                    <option value="">Select Salutation</option>
                                    @if (salutation())
                                        @foreach (salutation() as $item)
                                            <option value="{{ $item }}" @if($item==old('salutation')) selected @endif>
                                                {{ $item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="firstname" class=" control-label">First Name</label>
                                <input class="form-control" placeholder="" value="{{ old('firstname') }}"
                                       name="firstname" type="text" id="">
                            </div>

                            <div class="form-group">
                                <label for="lastname" class=" control-label">Last Name</label>
                                <input class="form-control" placeholder="" value="{{ old('lastname') }}" name="lastname"
                                       type="text" id="">
                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label">Organisation</label>
                                <input class="form-control" placeholder="" value="{{ old('organisation') }}"
                                       name="organisation" type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="job_title" class=" control-label">Job Title</label>
                                <input class="form-control " placeholder="" value="{{ old('job_title') }}"
                                       name="job_title" type="text" id="">
                            </div>

                            <div class="form-group">
                                <label for="" class=" control-label">Telephone Number</label>

                                <select class="form-control countries" >
                                    @if (CountryList())
                                        @foreach (CountryList() as $item)
                                            <option value="{{ $item->phonecode }}" data-iso="{{$item->iso}}"  @if($item->iso=='SG') selected @endif>&nbsp;+{{ $item->phonecode }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for="" class=" control-label">Mobile Number</label>

                                <select class="form-control countries" >
                                    @if (CountryList())
                                        @foreach (CountryList() as $item)
                                            <option value="{{ $item->phonecode }}" data-iso="{{$item->iso}}"  @if($item->iso=='SG') selected @endif>&nbsp;+{{ $item->phonecode }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="payee_name" class=" control-label">Payee Name</label>
                                <input class="form-control" placeholder="" value="{{ old('payee_name') }}"
                                       name="payee_name" type="text" id="payee_name">
                            </div>

                            <div class="form-group">
                                <label for="payment_mode" class="control-label">Payment Mode</label>

                                <select name="payment_mode" class="form-control select2" id="selectpicker"
                                        data-placeholder="Select Status">
                                    @foreach(get_payment_mode() as $k => $v)
                                        <option value="{{$k}}"
                                                @if(old('payment_mode')==$k) selected @endif>{{$v}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>

                                <select name="status" class="form-control select2" id="selectpicker"
                                        data-placeholder="Select Status">
                                    @foreach(get_status() as $k => $v)
                                        <option value="{{$k}}" @if(old('status')==$k) selected @endif>{{$v}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>

                        </div>
                    </form>
                    <!-- /.box -->
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
<script id="script_e4">
    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var iso = item.element.dataset.iso;
        var img = $("<img>", {
            class: "img-flag",
            width: 26,
            src: APP_URL + '/flags_iso/24/'+iso.toLowerCase()+'.svg'
        });
        var span = $("<span>", {
            text: " " + item.text
        });
        span.prepend(img);
        return span;
    }

    $(document).ready(function () {
        $(".countries").select2({
            templateResult: function (item) {
                return format(item, false);
            }
        });
    });

</script>
@endpush
