
            <form name="subscription" action="" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-6">
                    <div class="container">
                    @include('admin.inc.message')
                    <h3>Subscribe to our Regulatory Update Today!</h3>
                    <div class="input-group">
                    <input pattern="[^@\s]+@[^@\s]+\.[^@\s]+" id="emailid"  name="emailid" type="text" required="required" class="form-control" placeholder="Enter Your Email Address Here" />
                    <span class="input-group-btn">
                    <button type="submit" class="btn-3">Subscribe Now</button>
                    
                    </span>
                    
                    </div>
                    <div id="s_message"></div>
                    </div>
                    </div>
 				</form>
                
                
                <script type="text/javascript">

    $(document).ready(function() {
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$("form[name='subscription']").on("submit", function(e) {
			 e.preventDefault(); 
			var emailid= $("#emailid").val();	
			$.ajax({
                type: 'GET',
                url: "{{ url('/subscribers') }}",
                data: {
                    emailid:emailid,
                    _token: CSRF_TOKEN,
                },
                cache: false,
                async: false,
                success: function (data) {
			       $("#s_message").html(data);
				   $("#emailid").val("");
                }
            });   
		   
        });
			
			
    });    
 </script>
 <style type="text/css">
.error { color: ##440808; text-align:center; font-weight:bold; margin-top:10px; }
.success { color: #096;text-align:center; font-weight:bold;  margin-top:10px;}
 </style>