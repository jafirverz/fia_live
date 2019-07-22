<a href="#find-pp" class="btn-find" data-toggle="modal"><span>?</span>Send Us Your Enquiry / Feedback</a>
<div id="find-pp" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            <h3 class="md-title">Send Us Your Enquiry / Feedback</h3>
             <form id="feedback" name="feedback" class="form-type form-ani" method="post" action="{{ url('/feedback-store')}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="inrow">
                    <span><input name="name" type="text" class="form-control" /></span>
                    <label><span class="required">*</span> Name</label>
                </div>
                <div class="inrow">
                    <span><input name="emailid" type="text" class="form-control" /></span>
                    <label><span class="required">*</span> Email Address</label>
                </div>
                <div class="inrow">
                    <span><textarea name="message" cols="30" rows="7" class="form-control"></textarea></span>
                    <label><span class="required">*</span> Message</label>
                </div>
                <div class="row output break-480">
                    <div class="col-xs-6 col-xs-push-6 col">
                        <button type="submit" class="btn-2">Send</button>
                    </div>
                    <div class="col-xs-6 col-xs-pull-6 col">
                        <a class="btn-4" data-dismiss="modal" href="#">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->