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
        {{ Breadcrumbs::render('groupmanagement') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <a href="{{ url('admin/group-management/create') }}"
                           class="btn btn-primary pull-right">Create</a>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Members</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($groups)
                                        @foreach($groups as $group)
                                            <?php  $groupMembers = memberByGroupIds($group->id); ?>
                                            <tr>
                                                <td>{{ $group->group_name ?? '-' }}</td>
                                                <td>@if(!is_null($groupMembers) && $groupMembers->count() )
                                                        <?php
                                                        $groupMembersArray = $groupMembers->pluck('full_name')->all();
                                                        ?>
                                                        {{implode(',',$groupMembersArray)}}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ inactiveActive($group->status) ?? '-' }}</td>
                                                <td>
                                                    <table class="action-table">
                                                        <tr>
                                                            <td>
                                                                <a href="{{ url('admin/group-management/edit', $group->id) }}"
                                                                   class="btn btn-info" title="Edit"><i class="fa fa-pencil"
                                                                                                        aria-hidden="true"></i></a>
                                                            </td>
                                                            <td>
                                                                <form action="{{ url('admin/group-management/destroy') }}"
                                                                      method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"
                                                                            onclick="return confirm('Are you sure you want to delete?');"
                                                                            title="Delete"><i class="fa fa-trash"
                                                                                              aria-hidden="true"></i></button>
                                                                    <input type="hidden" name="id" value="{{ $group->id }}">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </table>


                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
@endsection
