@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('page_create') }}
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
                    <form name="filter" method="post" action="{{ url('/admin/page/store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class=" control-label">Title</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('title') }}" name="title" type="text">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" control-label">Friendly URL</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('slug') }}" name="slug" type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class=' control-label' for="contents">Contents :</label>

                            <div class="">
                                <textarea class="tiny-editor form-control" rows="5" id="contents"
                                          name="contents">{{ old('contents') }}</textarea>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label for="meta_title" class=" control-label">Meta Title</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('meta_title') }}" name="meta_title" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_auther" class=" control-label">Meta Auther</label>
                            <div class="">
								<input class="form-control" placeholder="" value="{{ old('meta_auther') }}" name="meta_auther" type="text">                                           
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword" class=" control-label">Meta Keyword</label>
                            <div class="">
							<input class="form-control" placeholder="" value="{{ old('meta_keyword') }}" name="meta_keyword" type="text">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=' control-label' for="contents">Meta Description :</label>

                            <div class="">
                                <textarea class=" form-control" rows="5" id="description"
                                          name="meta_description">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>-->
                        
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
					</form>
                </div>
                <!-- /.box-body -->


               
            </div>
            <!-- /.box -->
        </div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('scripts')
@endpush
