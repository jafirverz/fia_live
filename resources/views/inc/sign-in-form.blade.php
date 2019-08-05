
<div id="find-pp" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            <!--<style>
            .grecaptcha-badge{position:relative !important; right:0 !important; left:0 !important;}
            </style>-->
             @include('admin.inc.message')
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
            <input type="hidden" name="redirect" value="{{ url('topical-reports')}}">
        </div>
        <!--<div class="form-group">
                <div class="google-recaptcha">
                    <div class="g-recaptcha" data-callback="onSubmit"
                        data-sitekey="{{env('CAPTCHA_SITE_KEY')}}" data-size="invisible"></div>
                    <input type="hidden" title="Please verify this" class="required" name="keycode"
                        id="keycode">
                    <div id="cap-response" style="display:none; color:#F00;"></div>

                </div>
            </div>-->
        <button type="submit" class="btn-2">Sign in</button>
        <div class="links">
            <a href="#">Forgot Password?</a>
        </div>
    </form>
        </div>
    </div>
</div><!-- /.modal -->