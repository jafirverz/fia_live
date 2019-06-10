@extends('admin.layout.app') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('filter_edit', $filter->id) }}
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
                   
                     <form name="filter" method="post" action="{{ url('/admin/filter/update/'.$filter->id)}}">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="box-body">
                        <div class="form-group">
<label for="filter_name" class=" control-label">Filter Name</label>                           
                            <div class="">
 <select  name="filter_name" class="form-control select2"  id="selectpicker" data-placeholder="Select Type" >
						<option value="">Choose One</option>
						@foreach(get_filter_name() as $k => $v)
                            <option value="{{$k}}"  @if($filter->filter_name==$k) selected="selected" @endif>{{$v}}</option>
                        @endforeach                            
</select> 
                                           </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="tag_name" class=" control-label">Tag Name</label>
                            
                           <input class="form-control" placeholder="" value="{{ $filter->tag_name }}" name="tag_name" type="text" id="tag_name">                            
 
                        </div>
                        <div class="form-group">
                            <label for="home_status" class="control-label">Home Page Status</label>
                            <div class="">
						<input  name="home_status" @if(1 == $filter->home_status) checked="checked" @endif  type="checkbox" id="tag_name" value="1">                            
                            </div>
                        </div>
                        <div class="form-group">
							<label for="status" class=" control-label">Status</label>
                            <div class="">
                            <select  name="status" class="form-control select2"  id="selectpicker" data-placeholder="Select Status" >
                            @foreach(ActiveInActinve() as $k => $v)
                            <option value="{{$k}}"  @if($filter->status==$k) selected @endif>{{$v}}</option>
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
