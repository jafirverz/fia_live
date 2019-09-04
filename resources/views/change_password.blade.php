@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.banner')
        <form method="POST" action="{{ url('change-password') }}">
            @csrf
            <div class="container space-1">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {!! session('error') !!}
                    </div>
                @elseif(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {!! session('success') !!}
                    </div>
                @endif
                <div class="form-type">
                    <h1 class="title-1 text-center">Change Password</h1>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="lb"><span class="required">*</span> Old Password</label>
                            <input type="password" class="form-control @if ($errors->has('old_password')) is-invalid @endif"
                                name="old_password" value="" />
                            @if ($errors->has('old_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                            <label class="lb"><span class="required">*</span> New Password</label>
                            <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif"
                                name="password" value="" />
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            <label class="lb"><span class="required">*</span> Confirm Password</label>
                            <input type="password" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" value="" />
                            @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                            <button type="submit" class="btn-2" style="margin-top: 15px;">Save changes</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div><!-- //main -->

</div><!-- //page -->
@endsection
