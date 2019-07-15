<div class="space-1">
    <form action="{{ route('login') }}" method="POST" class="form-wrap-1 form-type form-ani">
        @csrf
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
                        data-sitekey="6Lf7LawUAAAAAF81NXrWPmOJ3HmDXwRZfDCsURC3" data-size="invisible"></div>
                    <input type="hidden" title="Please verify this" class="required" name="keycode"
                        id="keycode">
                    <div id="cap-response" style="display:none; color:#F00;"></div>

                </div>
            </div>
        <button type="submit" class="btn-2">Sign in</button>
        <div class="links">
            <a href="#">Forgot Password?</a>
        </div>
    </form>
</div>
