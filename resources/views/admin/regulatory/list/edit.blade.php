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
        {{ Breadcrumbs::render('regulatory_list_edit', $parent_id, $regulatory->id) }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/regulatory/list/'.$parent_id.'/update', $regulatory->id) }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter title"
                                    value="{{ $regulatory->title }}">
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('agency_responsible') ? ' has-error' : '' }}">
                                <label for="">Agency Responsible</label>
                                <input type="text" name="agency_responsible" class="form-control"
                                    placeholder="Enter agency responsible" value="{{ $regulatory->agency_responsible }}">
                                @if ($errors->has('agency_responsible'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('agency_responsible') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div
                                class="form-group{{ $errors->has('date_of_regulation_in_force') ? ' has-error' : '' }}">
                                <label for="">Date of Regulation</label>
                                <input type="text" name="date_of_regulation_in_force" class="form-control datepicker"
                                    placeholder="Enter date of regulation"
                                    value="{{ $regulatory->date_of_regulation_in_force->format('Y-m-d') }}">
                                @if ($errors->has('date_of_regulation_in_force'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_of_regulation_in_force') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control tiny-editor" cols="30" rows="10"
                                    placeholder="Enter description">{!! $regulatory->description !!}</textarea>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('topic_id') ? ' has-error' : '' }}">
                                <label for="">Topics</label>
                                <select name="topic_id[]" class="form-control select2" style="width: 100%;" multiple>
                                    <option value="">-- Select --</option>
                                    @if($topics)
                                    @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}" @if(in_array($topic->id, json_decode($regulatory->topic_id))) selected @endif>{{ $topic->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('topic_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('topic_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('stage_id') ? ' has-error' : '' }}">
                                <label for="">Stage</label>
                                <select name="stage_id" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($stages)
                                    @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}" @if($stage->id==$regulatory->stage_id) selected @endif>{{ $stage->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('stage_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stage_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                                <label for="">Country</label>
                                <select name="country_id" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($countries)
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id==$regulatory->country_id) selected @endif>{{ $country->tag_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('country_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
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
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section>
</div>
@endsection
