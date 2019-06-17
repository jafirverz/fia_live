@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('email_template_edit', $emailTemplate->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    
                     <form name="email_template" method="post" action="{{ url('/admin/email-template/update/'.$emailTemplate->id)}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
							<label for="title" class=" control-label">Title</label>                            
                            <div class="">
                           <input class="form-control" placeholder="" value="{{ $emailTemplate->title }}" name="title" type="text" id="title">                            
                            </div>
                        </div>
                        <div class="form-group">
							<label for="subject" class=" control-label">Subject</label>                            
                            <div class="">
                           <input class="form-control" placeholder="" value="{{ $emailTemplate->subject }}" name="subject" type="text" id="subject">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=' control-label' for="contents">Contents :</label>

                            <div class="">
                                <textarea class="email-editor form-control" rows="5" id="contents"
                                          name="contents">{{ $emailTemplate->contents }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" control-label">Status</label>

                            <div class="">

                                <select class="form-control select2 "
                                        data-placeholder="" name="status"
                                        style="width: 100%;">
                                    <option value="">{{__('constant.NONE')}}</option>
                            @foreach(ActiveInActinve() as $k => $v)
                            <option value="{{$k}}"  @if($emailTemplate->status==$k) selected @endif>{{$v}}</option>
                            @endforeach 
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>

</form>                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
