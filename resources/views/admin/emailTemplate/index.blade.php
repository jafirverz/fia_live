@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('email_template') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                       {{-- <a href="{{ url('admin/email-template/create') }}" class="btn btn-primary pull-right">Create</a>--}}
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="email-templates" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Email Template</th>
                                <th>Status</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($emailTemplates->count())
                                @foreach($emailTemplates as $emailTemplate)
                                    <tr>
                                        <td>
                                            {{$emailTemplate->title}}
                                        </td>


                                        <td>
                                            @if($emailTemplate->status==1)
                                                {{__('constant.ACTIVATE')}}
                                            @elseif($emailTemplate->status==0)
                                                {{__('constant.DEACTIVATE')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($emailTemplate->created_at == null)
                                                {{$emailTemplate->created_at}}
                                            @endif
                                            {!!  date("Y-m-d H:i:s", strtotime($emailTemplate->created_at))   !!}

                                        </td>
                                        <td data-order="{{ $emailTemplate->updated_at }}">@if ($emailTemplate->updated_at == null)
                                                {{$emailTemplate->updated_at}}
                                            @endif
                                            {!!  date("Y-m-d H:i:s", strtotime($emailTemplate->updated_at))   !!}

                                        </td>
                                        <td>
                                            <a href="{{ url('admin/email-template/edit/' . $emailTemplate->id) }}"
                                               title="Edit  Email Template">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>
                                           {{-- <a href="{{ url('admin/email-template/destroy/' . $emailTemplate->id) }}"
                                               title="Destroy Email Template"
                                               onclick="return confirm('Are you sure you want to delete this Email template?');">
                                                <i class="fa fa-trash btn btn-danger" aria-hidden="true"></i>
                                            </a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
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
    $(document).ready(function() {
        $('#email-templates').dataTable( {
            'order': [3, 'desc'],
        });
    });

</script>
@endsection
