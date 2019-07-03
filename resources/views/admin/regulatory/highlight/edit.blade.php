@extends('admin.layout.dashboard')

@section('content')
@if($regulatory_highlight)
@php
    $other_highlight_array = [
        $regulatory_highlight->other_highlight1,
        $regulatory_highlight->other_highlight2,
        $regulatory_highlight->other_highlight3,
        $regulatory_highlight->other_highlight4,
        $regulatory_highlight->other_highlight5,
    ];
@endphp
@endif
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>{{ $subtitle }}</small>
        </h1>
        {{ Breadcrumbs::render('regulatory_create') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ url('admin/regulatory/highlight/update') }}" method="post">
            @csrf
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('main_highlight') ? ' has-error' : '' }}">
                                <label for="">Main Highlight</label>
                                <select name="main_highlight" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Select --</option>
                                    @if($regulatories)
                                    @foreach ($regulatories as $regulatory)
                                    <option value="{{ $regulatory->id }}" @if($regulatory_highlight) @if($regulatory_highlight->main_highlight==$regulatory->id) selected @endif @endif>{{ $regulatory->title }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('main_highlight'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('main_highlight') }}</strong>
                                </span>
                                @endif
                            </div>
                            @for ($i = 1; $i <= 5; $i++)
                            <div class="form-group{{ $errors->has('main_highlight'.$i) ? ' has-error' : '' }}">
                                    <label for="">Other Highlight {{ $i }}</label>
                                    <select name="other_highlight{{ $i }}" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Select --</option>
                                        @if($regulatories)
                                        @foreach ($regulatories as $regulatory)
                                        <option value="{{ $regulatory->id }}" @if($regulatory_highlight) @if(in_array($regulatory->id, array_values($other_highlight_array)) && in_array($i, $other_highlight_array)) selected @endif @endif>{{ $regulatory->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('main_highlight{{ $i }}'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('main_highlight'.$i) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endfor

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
