@extends('layouts.app')

@section('content')
            <div class="main-wrap">   
				@include('inc.banner');
				<div class="container space-1">	
					<div class="intro-1">
						<h1 class="title-1 text-center">Get In Touch With Us</h1>
						<p>You can get in touch with us at our hotline number <strong style="color: #303030;">(+65) 6235 3854</strong> or send us your enquiry here.</p>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-push-6">
                            <form id="contact" name="contact" class="form-type form-ani contact-form" method="post" action="{{ url('/contact-store')}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								<div class="inrow">
									<span><input name="name" type="text" class="form-control" /></span>
									<label><span class="required">*</span> Full Name</label>
								</div>	
								<div class="inrow">
									<span><input name="emailid" type="text" class="form-control" /></span>
									<label><span class="required">*</span> Email Address</label>
								</div>	
								<div class="inrow">
									<select name="enquiry_type" class="selectpicker">
										<option value="">Enquiry Type</option>
										<option value="Membership Enquiry">Membership Enquiry</option>
										<option value="General Enquiry">General Enquiry</option>
										<option value="Regulatory Advisory">Regulatory Advisory</option>
									</select>
								</div>	
								<div class="inrow">
									<span><textarea name="message" cols="30" rows="7" class="form-control"></textarea></span>
									<label><span class="required">*</span> Message</label>
								</div>	
								<div class="col-xs-12">
                            <div class="form-group">
                                <div class="google-recaptcha">
                                    <div class="g-recaptcha" data-callback="onSubmit" data-sitekey="6Lf7LawUAAAAAF81NXrWPmOJ3HmDXwRZfDCsURC3" data-size="invisible"></div>
                                    <input type="hidden" title="Please verify this" class="required" name="keycode" id="keycode">
                                    <div id="cap-response" style="display:none; color:#F00;"></div>

                                </div>
                            </div>
                        </div>
								<button type="submit" class="btn-2">SUBMIT ENQUIRY</button>
							</form>
						</div>
						<div class="col-md-6 col-md-pull-6">
							<div class="map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7816553237417!2d103.82973991532903!3d1.306139899047368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da198d6da26b6f%3A0x903ec0b530c304c5!2sSingapore+228208!5e0!3m2!1sen!2s!4v1554365546416!5m2!1sen!2s" width="600" height="470" frameborder="0" style="border:0" allowfullscreen></iframe></div>
						</div>
					</div>
				</div>
                
            </div><!-- //main -->
      

@endsection
