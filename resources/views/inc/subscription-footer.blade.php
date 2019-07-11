
            <form action="{{ url('/subscribers')}}" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-6">
                    <div class="container">
                    @include('admin.inc.message')
                    <h3>Subscribe to our Regulatory Update Today!</h3>
                    <div class="input-group">
                    <input pattern="[^@\s]+@[^@\s]+\.[^@\s]+"  name="emailid" type="text" required="required" class="form-control" placeholder="Enter Your Email Address Here" />
                    <span class="input-group-btn">
                    <button type="submit" class="btn-3">Subscribe Now</button>
                    </span>
                    </div>
                    </div>
                    </div>
 				</form>