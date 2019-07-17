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
                    <div class="box-header with-border">
                        <a href="{{ url('admin/user/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>

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
                                    <?php  $groupNames = memberGroupByUserIds($user->id); ?>
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
                                        <td>@if(!is_null($user->invoice()) && $user->invoice()->paid==1 )
                                                Paid @elseif(!is_null($user->invoice()) && $user->invoice()->paid==0)
                                                Unpaid @else - @endif</td>
                                        <td>
                                            <?php
                                            $groupNames = $groupNames->pluck('group_name')->all();
                                            ?>
                                            @if(count($groupNames))
                                                {{implode(',',$groupNames)}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-order="<?php if (!is_null($user->invoice())) {
                                            echo $user->invoice()->created_at->format('d M, Y H:i:s');
                                        }?>">
                                            @if(!is_null($user->invoice()) )
                                                {{ $user->invoice()->created_at->format('d M, Y')}}
                                            @else - @endif
                                        </td>

                                        <td>@if($user->status==5)Active @else Inactive @endif</td>
                                        <td>
                                            @if(!is_null($user->invoice()) && $user->invoice()->period_type=='Month' )
                                                {{date('d M, Y', strtotime("+".$user->invoice()->period_value." months", strtotime($user->invoice()->created_at)))}}
                                            @elseif(!is_null($user->invoice()) && $user->invoice()->period_type=='Year')
                                                {{date('d M, Y', strtotime("+".$user->invoice()->period_value." years", strtotime($user->invoice()->created_at)))}}
                                            @else - @endif
                                        </td>
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
                                                           onclick="return confirm('Are you sure you want to delete this member?')"
                                                           href="{{ url('admin/user/destroy/' . $user->id) }}">
                                                            <i class="fa fa-trash btn btn-danger"> Delete</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table>
                                                <tr>
                                                    <td>

                                                        <a class="update-status" title="Approve and send payment"
                                                           href="#" data-member-type="{{$user->member_type}}"
                                                           data-user-id="{{$user->id}}" data-title="Approve and Send
                                                                Payment"
                                                           data-status="{{__('constant.PENDING_FOR_PAYMENT')}}">
                                                            <i class="fa fa-send btn btn-success"> Approve and Send
                                                                Payment</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="update-status" title="Approve"
                                                           href="#" data-member-type="{{$user->member_type}}"
                                                           data-user-id="{{$user->id}}" data-title="Approve"
                                                           data-status="{{__('constant.ACCOUNT_ACTIVE')}}">
                                                            <i class="fa fa-check btn btn-success"> Approve</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a class="" title="Reject"
                                                           onclick="return confirm('Are you sure to reject this user?')"
                                                           href="{{ route('update-status',['id'=>$user->id,'status'=>3]) }}">
                                                            <i class="fa fa-ban btn btn-danger"> Reject</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="" title="Unsubscribe"
                                                           onclick="return confirm('Are you sure to unsubscribe this user?')"
                                                           href="{{ route('update-status',['id'=>$user->id,'status'=>11]) }}">
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
        <div class="modal fade" id="payment-approve-modal" style="display: none;">
            <form action="{{ route('update-status') }}" method="POST">
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title button-title">Approve and Send Payment</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="member_type" class=" control-label">Member Type</label>
                                        <select class="form-control select2" name="member_type" id="member-type" style="width: 100%">
                                            @if (memberType())
                                                @foreach (memberType() as $key=>$member)
                                                    <option value="{{ $key }}">{{ $member }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" name="status" value="" id="status">
                                        <input type="hidden" name="user_id" value="" id="user-id">
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary button-title">Approve and send payment link</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </form>
            <!-- /.modal-dialog -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('scripts')
<script>
    $('.update-status').click(function() {
        var memberType = $('#member-type');
        memberType.val($(this).data('member-type'));
        memberType.change();
        $('#status').val($(this).data('status'));
        $('#user-id').val($(this).data('user-id'));
        $( ".button-title" ).html($(this).data('title'));
        $('#payment-approve-modal').modal('show');
    });

    $('#users').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[15, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [17],
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