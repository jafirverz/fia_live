@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('menu') }}
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
<form name="filter" method="post" action="{{ url('/admin/menu/type-update/'.$menu_type->id)}}">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">                    
                     <div class="box-body">
                        <div class="form-group">
                            <label for="tag_name" class=" control-label">Menu Name</label>
                            
                           <input class="form-control" placeholder="" value="{{ $menu_type->menu_name }}" name="menu_name" type="text">                            
 
                        </div>
                        <div class="form-group">
                            <label for="tag_name" class=" control-label">View Order</label>
                            
                           <input class="form-control" placeholder="" value="{{ $menu_type->view_order }}" name="view_order" type="text">                            
 
                        </div>
                        <div class="form-group">
							<label for="status" class=" control-label">Status</label>
                            <div class="">
                            <select  name="status" class="form-control select2"  id="selectpicker" data-placeholder="Select Status" >
                            @foreach(ActiveInActinve() as $k => $v)
                            <option value="{{$k}}"  @if($menu_type->status==$k) selected @endif>{{$v}}</option>
                            @endforeach                            
                            </select>                            
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
