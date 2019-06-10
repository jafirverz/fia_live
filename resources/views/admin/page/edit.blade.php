@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('page_edit', $page->id) }}
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
                  <form name="filter" method="post" action="{{ url('/admin/page/update/'.$page->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
								<label for="title" class=" control-label">Title</label>                            
                                <div class="">
                                <input class="form-control" placeholder="" value="{{ $page->title }}" name="title" type="text">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" control-label">Slug</label>
                            <div class="">
                                @if($page->page_type == 2)
                                <input class="form-control lower-case" readonly="readonly" placeholder="" value="{{ $page->slug }}" name="slug" type="text">                            
                                @else
                                <input class="form-control lower-case" readonly="readonly" placeholder="" value="{{ $page->slug }}" name="slug" type="text">                            
                                @endif
                            </div>

                        </div>
                        
                        @if(in_array($page->page_type,[0,1]))
                            <div class="form-group">
                            <label class=' control-label' for="contents">Contents :</label>
                                <div class="">
                                    <textarea class="tiny-editor form-control" rows="5" id="contents"
                                          name="contents">{{ $page->contents }}</textarea>
                                </div>
                            </div>
                        @else
                        @endif
                        <div class="form-group">
                            <label for="meta_title" class=" control-label">Meta Title</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $page->meta_title }}" name="meta_title" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_auther" class=" control-label">Meta Auther</label>
                            <div class="">
								<input class="form-control" placeholder="" value="{{ $page->meta_auther }}" name="meta_auther" type="text">                                           
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword" class=" control-label">Meta Keyword</label>
                            <div class="">
							<input class="form-control" placeholder="" value="{{ $page->meta_keyword }}" name="meta_keyword" type="text">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=' control-label' for="contents">Meta Description :</label>
                            <div class="">
<textarea class=" form-control" rows="5" id="description"
                                          name="meta_description">{{ $page->meta_description }}</textarea>                            
                               </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                    </form>
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
