<footer class="footer-container">
    <div class="container info">
        <div class="line"></div>
        <div class="row row-col">
            <div class="col-md-7 col">
                <div class="row break-560 row-col">
                    <div class="col-sm-7 col-xs-6 col">
                        {!!  setting()->footer!!}
                    </div>
                    <div class="col-sm-5 col-xs-6 col">
                        <h4>Sitemap</h4>
                        {!! get_parent_menu(0,3,isset($page) ? $page->id : null) !!}
                        <!--<ul class="links">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="updates.html">Regulatory Updates</a></li>
                            <li><a href="reports.html">Topical Reports</a></li>
                            <li><a href="country.html">Country Information</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul>-->
                    </div>
                </div>
            </div>
            <div class="col-md-5 col">
                <div class="row break-560 row-col">
                    <div class="col-sm-7 col-xs-6 col">
                        <h4>Others</h4>
                        <!--<ul class="links">
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="temrs.html">Terms and Conditions</a></li>
                        </ul>-->
                        {!! get_parent_menu(0,4,isset($page) ? $page->id : null) !!}
                        <h4 class="sp">Follow Us</h4>
                        {!!  setting()->social_link!!}
                    </div>
                    <div class="col-sm-5 col-xs-6 col">
                        <div class="logo">
                            <a href="{{url('/')}}"><img src="{{asset(setting()->logo)}}" alt="FIA" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>{!! setting()->footer_copyright !!} <!--<a href="webmaster.html">Web Excellence</a> by <span class="verz">Verz</span>--></p>
        </div>
    </div>
</footer><!-- //footer container -->

<a href="#toppage" class="smoothscroll gotop fas fa-angle-up">Go top</a>


<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $("form[name='contact']").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                emailid: {
                    required: true,
                    email: true
                },
                enquiry_type: "required",
                message: "required"

            },
            submitHandler: function (form) {
				
				if (grecaptcha.getResponse()) {
				// 2) finally sending form data
				form.submit();
				}else{
				// 1) Before sending we must validate captcha
				grecaptcha.reset();
				grecaptcha.execute();
				}  
				
				
				
            }
        });
    });
    $(document).ready(function () {
        $("form[name='mc-embedded-subscribe-form']").validate({
            rules: {
                EMAIL: {
                    required: true,
                    email: true
                }

            }
        });
    });
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


