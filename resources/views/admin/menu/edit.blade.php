@extends('admin.layout.app') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('menu_edit', $menu->id,$parentMenu) }}
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
                    {!! Form::open(['url' => ['/admin/menu/update', $menu->id], 'method' => 'post']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {{Form::label('title', 'Title',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('title', $menu->title, ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('parent_menu', 'Parent Menu',['class'=>' control-label'])}}
                            <div class="">
                                <input type="hidden" name="parent"
                                       value="{{!is_null($parentMenu)?$parentMenu->id:0}}"/>
                                {{Form::text('parent_menu',(!is_null($parentMenu)?$parentMenu->title:__('constant.MAIN_MENU')), ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
                            </div>
                        </div>
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
                                                    @if($page->id == $menu->page_id) selected="selected" @endif>{{ $page->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('view_order', 'View Order',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::number('view_order', $menu->view_order, ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" control-label">Status</label>

                            <div class="">

                                <select class="form-control select2 "
                                        data-placeholder="" name="status"
                                        style="width: 100%;">
                                    <option value="">{{__('constant.NONE')}}</option>
                                    <option value="1" @if($menu->status == 1) selected="selected" @endif>
                                        {{__('constant.ACTIVATE')}}
                                    </option>
                                    <option value="0" @if($menu->status == 0) selected="selected" @endif>
                                        {{__('constant.DEACTIVATE')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                    {!! Form::close() !!}
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
