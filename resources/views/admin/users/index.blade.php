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
        {{ Breadcrumbs::render('user') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Member Type</th>
                                <th>Organization</th>
                                <th>Job Title</th>
                                <th>Mobile Number</th>
                                <th>Telephone Number</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Payment Status</th>
                                <th>Group Name</th>
                                <th>Subscription Date</th>
                                <th>Subscription Status</th>
                                <th>Renewal Date</th>
                                <th>Registration Date</th>
                                <th>Overall Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($users->count())
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->firstname ?? '-' }}</td>
                                        <td>{{ $user->lastname ?? '-' }}</td>
                                        <td>
                                            {{memberType($user->member_type)}}
                                        </td>
                                        <td>{{ $user->organization ?? '-' }}</td>
                                        <td>{{ $user->job_title ?? '-' }}</td>
                                        <td>{{ '+'.$user->mobile_code}}&nbsp;{{$user->mobile_number ?? '-' }}</td>
                                        <td>{{ '+'.$user->telephone_code}}&nbsp;{{$user->telephone_number ?? '-' }}</td>
                                        <td>{{ $user->country ?? '-' }}</td>
                                        <td>{{ $user->city ?? '-' }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>Payment Status</td>
                                        <td>Group Name</td>
                                        <td data-order="<?php echo $user->created_at->format('d M, Y H:i:s') ?? '-' ?>">{{ $user->created_at->format('d M, Y H:i A') ?? '-' }}</td>
                                        <td>Subscription Status</td>
                                        <td>Renewal Date</td>
                                        <td>{{ $user->created_at->format('d M, Y H:i A') ?? '-' }}</td>
                                        <td>{{memberShipStatus($user->status)}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a class="" title="View User"
                                                           href="{{ url('admin/user/view/' . $user->id) }}">
                                                            <i class="fa fa-eye btn btn-success"> View</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="" title="Edit User"
                                                           href="{{ url('admin/user/edit/' . $user->id) }}">
                                                            <i class="fa fa-pencil btn btn-primary"> Edit</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="" title="Delete User"
                                                           onclick="return confirm('Are you sure to delete this user?')"
                                                           href="{{ url('admin/user/destroy/' . $user->id) }}">
                                                            <i class="fa fa-trash btn btn-danger"> Delete</i>
                                                        </a>
                                                    </td>
                                                </tr></table><table>
                                                <tr>
                                                    <td>
                                                        <a class="" title="Approve and send payment"
                                                           href="#">
                                                            <i class="fa fa-send btn btn-success"> Approve and Send
                                                                Payment</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="" title="Approve"
                                                           href="#">
                                                            <i class="fa fa-check btn btn-success"> Approve</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table><table>
                                                <tr>
                                                    <td>
                                                        <a class="" title="Reject"
                                                           href="#">
                                                            <i class="fa fa-ban btn btn-danger"> Reject</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="" title="Un-subscribe"
                                                           href="#">
                                                            <i class="fa fa-bell-slash btn btn-danger"> Unsubscribe</i>
                                                        </a>
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
@endsection
@push('scripts')
<script>
    $('#users').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[12, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [2, 6],
                    "bSortable": false
                },
                    {width: 100, targets: 0},
                    {width: 150, targets: 1},
                    {width: 300, targets: 2},
                    {width: 150, targets: 3},
                    {width: 150, targets: 4},
                    {width: 150, targets: 6}

                ]
            });
</script>
@endpush