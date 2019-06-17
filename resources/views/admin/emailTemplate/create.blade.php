@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('email_template_create') }}
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
                    {!! Form::open(['url' => '/admin/email-template/store', 'method' => 'post']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name"
                                   class="control-label">Title
                            </label>
                            <div class="">
                                <select class="form-control" name="email_template">
                                    <option value="">-Select Template Name-</option>
                                    @foreach($emailTemplates as $emailTemplate)
                                            <option value="{{ $emailTemplate->id }}">{{$emailTemplate->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('subject', 'Subject',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('subject', old('subject'), ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=' control-label' for="contents">Contents :</label>

                            <div class="">
                                <textarea class="email-editor form-control" rows="5" id="contents"
                                          name="contents">{{ old('contents') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" control-label">Status</label>

                            <div class="">

                                <select class="form-control select2"
                                        data-placeholder="" name="status"
                                        style="width: 100%;">
                                    <option value="">{{__('constant.NONE')}}</option>
                                    <option value="1" selected="selected">{{__('constant.ACTIVATE')}}</option>
                                    <option value="0">{{__('constant.DEACTIVATE')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
@push('scripts')
@endpush
