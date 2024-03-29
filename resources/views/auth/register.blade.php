@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner')
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="container space-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session('success') }}
                    </div>
                @endif
                {{-- @include('admin.inc.message') --}}
                <div class="form-type">
                    <h1 class="title-1 text-center">Create an Account</h1>
                    <div class="intro-1">
                        <p><strong><i>All employees of <a target="_blank" href="https://foodindustry.asia/membership-benefits">FIA member companies</a> may register for access. Membership of FIA is on a company basis. For membership enquiries, please get in touch with us <a target="_blank" href="{{url('contact-us')}}">here</a>.</i></strong></p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row row-1">
                                <div class="col-sm-4 col sl-1">
                                    <label class="lb">Salutation</label>
                                    <select class="selectpicker" data-live-search="true" name="salutation">
                                        <option value="">Select Salutation</option>
                                        @if (salutation())
                                        @foreach (salutation() as $item)
                                        <option value="{{ $item }}" @if($item==old('salutation')) selected @endif>
                                            {{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-8 col">
                                    <label class="lb"><span class="required">*</span> First Name</label>
                                    <input type="text"
                                        class="form-control @if ($errors->has('firstname')) is-invalid @endif"
                                        name="firstname" value="{{ old('firstname') }}" />
                                    @if ($errors->has('firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('firstname') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Last Name</label>
                            <input type="text" class="form-control @if ($errors->has('lastname')) is-invalid @endif"
                                name="lastname" value="{{ old('lastname') }}" />
                            @if ($errors->has('lastname'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('lastname') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Organisation</label>
                            <input type="text" class="form-control @if ($errors->has('organization')) is-invalid @endif"
                                name="organization" value="{{ old('organization') }}" />
                            @if ($errors->has('organization'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('organization') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">Job Title</label>
                            <input type="text" class="form-control" name="job_title" value="{{ old('job_title') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb">Telephone Number</label>
                            <div class="input-group ig-1">
                                <div class="input-group-addon sl-1">
                                    <select class="selectpicker" data-live-search="true" name="telephone_code">
                                        @if (CountryList())
                                        @foreach (CountryList() as $item)
                                        <option value="{{ $item->phonecode }}"
                                            data-content='<img src="{{ asset('flags_iso/24/'.strtolower($item->iso).'.svg') }}" alt="" /> +{{ $item->phonecode }}'
                                            @if($item->iso=='SG') selected @endif>
                                            +{{ $item->phonecode }}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                                <input type="text" class="form-control" name="telephone_number"
                                    value="{{ old('telephone_number') }}" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">Mobile Number</label>
                            <div class="input-group ig-1">
                                <div class="input-group-addon sl-1">
                                    <select class="selectpicker" data-live-search="true" name="mobile_code">
                                        @if (CountryList())
                                        @foreach (CountryList() as $item)
                                        <option value="{{ $item->phonecode }}"
                                            data-content='<img src="{{ asset('flags_iso/24/'.strtolower($item->iso).'.svg') }}" alt="" /> +{{ $item->phonecode }}'
                                            @if($item->iso=='SG') selected @endif>
                                            +{{ $item->phonecode }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="text" class="form-control" name="mobile_number"
                                    value="{{ old('mobile_number') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Country</label>
                            <select data-live-search="true" class="selectpicker @if ($errors->has('country')) is-invalid @endif" name="country">
                                <option value="">Select Country</option>
                                @if (CountryList())
                                @foreach (CountryList() as $item)
                                <option value="{{ $item->country }}" @if($item->country==old('country')) selected
                                    @endif>{{ $item->country }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('country') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">City</label>
                            <input type="text" class="form-control"  name="city" value="{{ old('city') }}" />
                        </div>
                    </div>
                    <label class="lb">Address Line 1</label>
                    <input type="text" class="form-control" name="address1" value="{{ old('address1') }}" />
                    <label class="lb">Address Line 2</label>
                    <input type="text" class="form-control" name="address2" value="{{ old('address2') }}" />
                </div>
            </div>
            <div class="box-2">
                <div class="container">
                    <div class="form-wrap-1 form-type form-ani">
                        <p class="text-center" style="margin-bottom: 20px;">This will also serve as your username.</p>
                        <div class="inrow">
                            <span><input type="text" class="form-control  @if ($errors->has('email')) is-invalid @endif"
                                    name="email" value="{{ old('email') }}" /></span>
                            <label><span class="required">*</span> Email Address</label>
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <span><input type="password"
                                    class="form-control @if ($errors->has('password')) is-invalid @endif"
                                    name="password" /></span>
                            <label><span class="required">*</span> Password</label>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                        </div>
                        <div class="inrow">
                            <span><input type="password"
                                    class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif"
                                    name="password_confirmation" /></span>
                            <label><span class="required">*</span> Confirm Password</label>
                            @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                            @endif
                        </div>
                        <div class="checkbox"><input type="checkbox" id="update" name="subscribe_status"
                                value="1" /><label for="update">I’d like to subscribe to the FIA Regulatory Hub newsletter to receive the latest regulatory updates.</label></div>
                        <div class="form-group">
                            <div class="google-recaptcha">
                                <div class="g-recaptcha" data-callback="onSubmit"
                                    data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                                <input type="hidden" title="Please verify this" class="required" name="keycode"
                                    id="keycode">
                                <div id="cap-response" style="display:none; color:#F00;"></div>

                            </div>
                        </div>
                        <div class="row output break-480">
                            <div class="col-xs-6 col-xs-push-6 col">
                                <button type="submit" class="btn-2">Register</button>
                            </div>
                            <div class="col-xs-6 col-xs-pull-6 col">
                                <a class="btn-4" href="{{ url('/') }}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div><!-- //main -->

</div><!-- //page -->
@endsection
