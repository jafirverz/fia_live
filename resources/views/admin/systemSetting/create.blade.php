@extends('admin.layout.app') @section('content')
        <!-- Content Wrapper. Contains system-setting content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('system-setting-create') }}
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
                    {!! Form::open(['url' => '/admin/system-setting/store', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {{Form::label('title', 'Title',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('logo', 'Logo',['class'=>' control-label'])}}
                            <div class="  ">
                                {{Form::file('logo', ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('email_sender_name', 'Email Sender Name',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('email_sender_name', '', ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('from_email', 'From Email',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('from_email', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('to_email', 'To Email',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('to_email', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('contact_phone', 'Contact No',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('contact_phone', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('contact_email', 'Contact Email',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('contact_email', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('contact_fax', 'Contact Fax',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::text('contact_fax', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('contact_address', 'Address',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::textarea('contact_address','', ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('company_map', 'Map',['class'=>' control-label'])}}
                            <div class="">
                                {{Form::textarea('company_map','', ['class' => 'form-control tiny-editor', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('footer', 'Footer',['class'=>' control-label '])}}
                            <div class="">
                                {{Form::text('footer', '', ['class' => 'form-control tiny-editor', 'placeholder' => ''])}}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div>
                <!-- /.box-body -->


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
