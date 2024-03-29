<div class="space-1">
        @include('admin.inc.message')
    <form class="form-wrap-1 form-type form-ani" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <h1 class="title-1 text-center">Sign in to your account</h1>
        <div class="inrow">
            <span><input type="text" name="email" class="form-control" /></span>
            <label>Email Address</label>
        </div>
        <div class="inrow">
            <span><input type="password" name="password" class="form-control" /></span>
            <label>Password</label>
            <input type="hidden" name="redirect" value="{{ url()->full() }}">
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
            <div class="checkbox text-center">
                <input type="checkbox"  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} /><label for="remember">Remember me?</label>
            </div>
        <button type="submit" class="btn-2">Sign in</button>
        <div class="links">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
            <p>Don't have an account yet? <a href="{{ url('register') }}">Create account</a></p>
        </div>
    </form>
</div>
