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
        {{ Breadcrumbs::render('regulatory_list_create', $parent_id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/regulatory/list/'.$parent_id.'/store') }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter title"
                                    value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div
                                class="form-group{{ $errors->has('regulatory_date') ? ' has-error' : '' }}">
                                <label for="">Date</label>
                                <input type="text" name="regulatory_date" class="form-control datepicker"
                                    placeholder="Enter date"
                                    value="{{ old('regulatory_date') }}">
                                @if ($errors->has('regulatory_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('regulatory_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control tiny-editor" cols="30" rows="10"
                                    placeholder="Enter description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('impact_on_industry') ? ' has-error' : '' }}">
                                <label for="">Impact on Industry</label>
                                <textarea name="impact_on_industry" class="form-control tiny-editor" cols="30" rows="10"
                                          placeholder="Enter Impact on Industry">{{ old('impact_on_industry') }}</textarea>
                                @if ($errors->has('impact_on_industry'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('impact_on_industry') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('stage_id') ? ' has-error' : '' }}">
                                <label for="">Stage</label>
                                <select name="stage_id" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($stages)
                                    @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('stage_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stage_id') }}</strong>
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
                    <a href="{{ url('admin/regulatory') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
@endsection
