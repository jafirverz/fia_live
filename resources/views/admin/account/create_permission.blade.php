@extends('admin.layout.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        {{ $page_title }}
        </h1>
        {{ Breadcrumbs::render('create-roles-and-permission') }}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form name="filter" method="post" action="{{ url('/admin/roles-and-permission/store')}}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Role Name</label>
                            <input type="text" name="role_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="modules" class="col-sm-2 control-label">Modules</label>
                            <div class="col-sm-10">
                                @php $i = 0; @endphp
                                @foreach($modules as $module)
                                <table class="table row border">
                                    <tbody>
                                        <tr>
                                            <input type="hidden" name="module[<?php echo $i; ?>][name][]" value="<?php echo $module; ?>">
                                            <th colspan="2" style="border:0;"><?php echo $module; ?></th>
                                        </tr>
                                        <tr>
                                            <td>View
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][view][]" value="1" {{ get_permission_access_value('views', $module, 1) }}>Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][view][]" value="0" {{ get_permission_access_value('views', $module, 0) }}>No
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Create</td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][create][]" value="1" {{ get_permission_access_value('creates', $module, 1) }}>Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][create][]" value="0" {{ get_permission_access_value('creates', $module, 0) }}>No
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Edit</td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][edit][]" value="1" {{ get_permission_access_value('edits', $module, 1) }}>Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][edit][]" value="0" {{ get_permission_access_value('edits', $module, 0) }}>No
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Delete
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][delete][]" value="1"  {{ get_permission_access_value('deletes', $module, 1) }}>Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="module[<?php echo $i; ?>][delete][]" value="0" {{ get_permission_access_value('deletes', $module, 0) }}>No
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default" href="{{ url('/admin/roles-and-permission') }}">
                            Cancel
                        </a>
                        <button class="btn btn-primary pull-right" type="submit">
                        <i aria-hidden="true" class="fa fa-floppy-o">
                        </i>
                        Submit
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.row (main row) -->
<!-- /.content -->
<!-- /.content-wrapper -->
@endsection
