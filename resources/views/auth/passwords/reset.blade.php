@extends('layouts.app')

@section('content')
@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        <div class="container space-1">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                    <label for="email" class="lb">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                </div>

                <div class="form-group row">
                    <label for="password" class="lb">{{ __('Password') }}</label>

                    <input id="password" type="password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        required autocomplete="new-password">

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
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
                <div class="form-group row">
                    <label for="password-confirm"
                        class="lb">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                </div>

                <div class="form-group row mb-0">
                        <button type="submit" class="btn-2">
                            {{ __('Reset Password') }}
                        </button>
                </div>
            </form>
        </div>

    </div><!-- //main -->

</div><!-- //page -->
@endsection
