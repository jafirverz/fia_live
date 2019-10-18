@extends('admin.layout.dashboard')
@section('content')
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

                    <form name="filter" method="post" action="{{ url('/admin/filter/update/'.$filter->id)}}"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="filter_name" class=" control-label">Filter Name</label>

                                <div class="">
                                    <select name="filter_name" class="form-control select2" id="selectpicker"
                                            data-placeholder="Select Type">
                                        <option value="">Choose One</option>
                                        @foreach(get_filter_name() as $k => $v)
                                            <option value="{{$k}}"
                                                    @if($filter->filter_name==$k) selected="selected" @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tag_name" class=" control-label">Tag Name</label>

                                <input class="form-control" placeholder="" value="{{ $filter->tag_name }}"
                                       name="tag_name" type="text" id="tag_name">

                            </div>
                            <div class="form-group @if($filter->filter_name!=1) hide else '' @endif"
                                 id="country_image_id">
                                <div class="form-group">
                                    <label class="checkbox-inline"><input
                                                @if(1 == $filter->country_information) checked="checked"
                                                @endif type="checkbox" name="country_information" value="1"><strong>Country
                                            Information</strong></label>
                                </div>
                                @if(in_array($filter->tag_name,getHomeMapCountry()))
                                <div class="form-group">
                                    <label class="checkbox-inline"><input
                                                @if(1 == $filter->home_status) checked="checked" @endif type="checkbox"
                                                name="home_status" value="1"><strong>Active on map</strong></label>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label class='control-label' for="">Country Image :</label>

                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="country_image" data-input="thumbnail" data-preview="holder"
                                           class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                        <input id="thumbnail" class="form-control" type="text" name="country_image">


                                    </div>
                                    <img id="holder"
                                         @if($filter->country_image!="") src="{{url($filter->country_image)}}"
                                         @endif  style="margin-top:15px;max-height:100px;">

                                    <p class="text-muted"><strong>Note:</strong> Image size should be W:60 H:40 for
                                        better display</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order_by" class="control-label">View Order</label>

                                <input type="number" name="order_by" value="{{ $filter->order_by }}"
                                       class="form-control"/>

                            </div>
                            <div class="form-group">
                                <label for="status" class=" control-label">Status</label>

                                <div class="">
                                    <select name="status" class="form-control select2" id="selectpicker"
                                            data-placeholder="Select Status">
                                        @foreach (inactiveActive() as $key => $value)
                                            <option @if($filter->status==$key) selected
                                                    @endif value="{{ $key }}">{{ $value }}</option>
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
<script>
    $(document).ready(function () {
        $('#country_image').filemanager('image');
        $("select[name='filter_name']").on("change", function () {
            if ($(this).val() == 1) {
                $("#country_image_id").removeClass('hide');
            }
            else {
                $("#country_image_id").addClass('hide');
            }
        });
    });

</script>

@endsection
