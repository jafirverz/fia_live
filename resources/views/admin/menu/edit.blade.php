@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('menu_edit', $menu->id,$parentMenu,$_GET['type']) }}
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

				<form method="post" action="{{ url('/admin/menu/update/'.$menu->id)}}"> 
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">                     
                     <div class="box-body">
                        <div class="form-group">
                            <label for="title" class=" control-label">Title</label>
                            <div class="">
                           <input class="form-control" placeholder="" value="{{ $menu->title }}" name="title" type="text">                            
                            </div>
                        </div>
                        @if(!is_null($parentMenu))
                        <div class="form-group">
                            <label for="parent_menu" class=" control-label">Parent Menu</label>
                            <div class="">
                                <input type="hidden" name="parent" value="{{$parentMenu->id }}"/>
                    <input class="form-control" placeholder="" value="{{ $parentMenu->title }}" name="parent_menu" type="text" readonly="readonly">                            

                            </div>
                        </div>
                        @else
                        <input type="hidden" name="parent" value="0"/>
                        @endif
                        <div class="form-group">
                            <label class=" control-label">Page</label>

                            <div class="">

                                <select class="form-control select2"
                                        data-placeholder="" name="page_id"
                                        style="width: 100%;">
                                    <option value="null">{{__('constant.NONE')}}</option>
                                    @if($pages->count())
                                        @foreach($pages as $page)
                                            <option value="{{ $page->id }}"
                                                    @if($page->id == $menu->page_id) selected="selected" @endif>{{ $page->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_order" class=" control-label">Open link in a new window </label>
                            <div class="">
                           <input value="1" @if($menu->target_value==1) checked="checked" @endif id="checkbox1" name="target_value" type="checkbox">  
                           @if($menu->target_value==1)
                           <input class="form-control" value="{{ $menu->external_link }}" name="external_link" id="external_link" placeholder="External Link" type="text">                          
                           @else
                           <input class="form-control hide" value="" name="external_link" id="external_link" placeholder="External Link" type="text">                          
                           @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_order" class=" control-label">View Order</label>
                            <div class="">
                           <input class="form-control" placeholder="" value="{{ $menu->view_order }}" name="view_order" type="text">                            
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
                            <option value="{{$k}}"  @if($menu->status==$k) selected @endif>{{$v}}</option>
                            @endforeach 
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="menu_type" value="{{ $_GET['type'] }}" />
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
<script>
$(document).ready(function() {
    //set initial state.

    $('#checkbox1').change(function() {
        if($(this).is(":checked")) {
           $("#external_link").removeClass('hide');
		   $("#page_id").prop("disabled", true);
        }
		else
		{
			$("#external_link").addClass('hide');
			$("#page_id").prop("disabled", false);
		}
              
    });
});
</script>
@endsection
