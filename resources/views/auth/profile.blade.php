@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner')
        <form method="POST" action="{{ url('profile-update', $user->student_id) }}">
            @csrf
            <div class="container space-1">
                @include('admin.inc.message')
                <div class="form-type">
                    <h1 class="title-1 text-center">My Profile</h1>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row row-1">
                                <div class="col-sm-4 col sl-1">
                                    <label class="lb">Salutation</label>
                                    <select class="selectpicker" name="salutation">
                                        <option value="">Select Salutation</option>
                                        @if (salutation())
                                        @foreach (salutation() as $item)
                                        <option value="{{ $item }}" @if($item==$user->salutation) selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-8 col">
                                    <label class="lb"><span class="required">*</span> First Name</label>
                                    <input type="text"
                                        class="form-control @if ($errors->has('firstname')) is-invalid @endif"
                                        name="firstname" value="{{ $user->firstname }}" />
                                    @if ($errors->has('firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Last Name</label>
                            <input type="text" class="form-control @if ($errors->has('lastname')) is-invalid @endif"
                                name="lastname" value="{{ $user->lastname }}" />
                            @if ($errors->has('lastname'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Organisation</label>
                            <input type="text" class="form-control @if ($errors->has('organization')) is-invalid @endif"
                                name="organization" value="{{ $user->organization }}" />
                            @if ($errors->has('organization'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('organization') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">Job Title</label>
                            <input type="text" class="form-control" name="job_title" value="{{ $user->job_title }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb">Telephone Number</label>
                            <div class="input-group ig-1">
                                <div class="input-group-addon sl-1">
                                    <select class="selectpicker" name="telephone_code">
                                        @if (CountryList())
                                        @foreach (CountryList() as $item)
                                        <option value="{{ $item->phonecode }}"
                                            data-content='<img src="{{ asset('flags_iso/24/'.strtolower($item->iso).'.png') }}" alt="" /> +{{ $item->phonecode }}'
                                            @if($item->phonecode==$user->telephone_code) selected @endif>
                                            +{{ $item->phonecode }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="text" class="form-control" name="telephone_number"
                                    value="{{ $user->telephone_number }}" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">Mobile Number</label>
                            <div class="input-group ig-1">
                                <div class="input-group-addon sl-1">
                                    <select class="selectpicker" name="mobile_code">
                                        @if (CountryList())
                                        @foreach (CountryList() as $item)
                                        <option value="{{ $item->phonecode }}"
                                            data-content='<img src="{{ asset('flags_iso/24/'.strtolower($item->iso).'.png') }}" alt="" /> +{{ $item->phonecode }}'
                                            @if($item->phonecode==$user->mobile_code) selected @endif>
                                            +{{ $item->phonecode }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="text" class="form-control" name="mobile_number"
                                    value="{{ $user->mobile_number }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Country</label>
                            <select class="selectpicker @if ($errors->has('country')) is-invalid @endif" name="country">
                                <option value="">Select Country</option>
                                @if (CountryList())
                                @foreach (CountryList() as $item)
                                <option value="{{ $item->country }}" @if($item->country==$user->country) selected
                                    @endif>{{ $item->country }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label class="lb">City</label>
                            <input type="text" class="form-control"  name="city" value="{{ $user->city }}" />
                        </div>
                    </div>
                    <label class="lb">Address Line 1</label>
                    <input type="text" class="form-control" name="address1" value="{{ $user->address1 }}" />
                    <label class="lb">Address Line 2</label>
                    <input type="text" class="form-control" name="address2" value="{{ $user->address2 }}" />
                </div>
            </div>
            <div class="box-2">
                <div class="container">
                    <div class="form-wrap-1 form-type form-ani">
                        <h2>Please enter your original password to confirm these changes</h2>
                        <div class="inrow">
                            <span><input type="password" class="form-control" name="password" /></span>
                            <label><span class="required">*</span> Confirm Password</label>
                        </div>
                        <div class="form-group">
                                <div class="google-recaptcha">
                                    <div class="g-recaptcha" data-callback="onSubmit"
                                        data-sitekey="6Lf7LawUAAAAAF81NXrWPmOJ3HmDXwRZfDCsURC3" data-size="invisible"></div>
                                    <input type="hidden" title="Please verify this" class="required" name="keycode"
                                        id="keycode">
                                    <div id="cap-response" style="display:none; color:#F00;"></div>

                                </div>
                            </div>
                        <div class="row output break-480">
                            <div class="col-xs-6 col-xs-push-6 col">
                                <button type="submit" class="btn-2">Save changes</button>
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
