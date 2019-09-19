@extends('layouts.app')

@section('content')
    <div class="main-wrap">
        @include('inc.banner')
        <div class="container thanks-wrap">
            <h1>Activate your Account!</h1>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    {{ session('error') }}
                </div>
            @endif

        </div>
        <div class="container space-1">
            <form method="POST" action="{{ route('resend.email.verification') }}">
                @csrf

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


                <div class="form-group row mb-0">
                    <button type="submit" class="btn-2">
                        {{ __('Resend Email') }}
                    </button>
                </div>
            </form>

        </div>
        <div class="container thanks-wrap">
            <img src="{{asset('images/bg-thanks.jpg')}}" alt="" />
        </div>
    </div><!-- //main -->


@endsection
