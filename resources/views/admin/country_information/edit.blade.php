@extends('admin.layout.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>{{ $subtitle }}</small>
        </h1>
        {{ Breadcrumbs::render('country_information_edit', $country_information->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/country-information/update', $country_information->id) }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                                <label for="">Country</label>
                                <select name="country_id" class="form-control select2" style="width: 100%;" >
                                    <option value="">-- Select --</option>
                                    @if($countries)
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if($country_information->country_id) @if($country->id==$country_information->country_id) selected @endif @endif>{{ $country->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('information_filter_id') ? ' has-error' : '' }}">
                                <label for="">Information Filter</label>
                                <select name="information_filter_id" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($categories)
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id==$country_information->information_filter_id) selected @endif>{{ $category->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('information_filter_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('information_filter_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('information_title') ? ' has-error' : '' }}">
                                <label for="">Title</label>
                                <input type="text" name="information_title" class="form-control"
                                    placeholder="Enter information title" value="{{ $country_information->information_title }}">
                                @if ($errors->has('information_title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('information_title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('information_content') ? ' has-error' : '' }}">
                                <label for="">Content</label>
                                <textarea name="information_content" class="form-control tiny-editor" cols="30" rows="10"
                                    placeholder="Enter content">{!! $country_information->information_content !!}</textarea>
                                @if ($errors->has('information_content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('information_content') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('ordering') ? ' has-error' : '' }}">
                                <label for="">Order</label>
                                <input type="number" name="ordering" class="form-control" min="0"
                                    placeholder="Enter order" value="{{ $country_information->ordering ?? 0 }}">
                                @if ($errors->has('ordering'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ordering') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('admin/country-information') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
@endsection
