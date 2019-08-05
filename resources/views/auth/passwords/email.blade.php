@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        <div class="container space-1">
            <h1 class="title-1 text-center">{{ __('Reset Password') }}</h1>

            <div class="row">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="lb">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                    </div>
					<div class="form-group">
                            <div class="google-recaptcha">
                                <div class="g-recaptcha" data-callback="onSubmit"
                                    data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                                <input type="hidden" title="Please verify this" class="required" name="keycode"
                                    id="keycode">
                                <div id="cap-response" style="display:none; color:#F00;"></div>

                            </div>
                        </div>
                    <div class="form-group row mb-0">
                        <button type="submit" class="btn-2">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
