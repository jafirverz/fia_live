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
        {{ Breadcrumbs::render('user-login-log') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- SELECT2 EXAMPLE -->

                <!-- /.box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Find Member</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="" data-original-title="Collapse">
                                <i class="fa fa-minus"></i></button>

                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <form name="user" method="post" action="{{ url('/admin/user/search')}}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class=" control-label">Name</label>
                                        <input class="form-control" placeholder="" value="{{ $search['name'] }}"
                                               name="name" type="text" id="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organisation" class=" control-label">Organisation</label>
                                        <input class="form-control" placeholder="" value="{{ $search['organization'] }}"
                                               name="organization" type="text" id="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class=" control-label">Email</label>
                                        <input class="form-control" placeholder="" value="{{ $search['email'] }}"
                                               name="email" type="text" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salutation" class=" control-label">Member Type</label>
                                        <select class="select2 form-control" name="member_type">
                                            <option value="">Select member type</option>
                                            @if (memberType())
                                                @foreach (memberType() as $key=>$item)
                                                    <option value="{{ $key }}"
                                                            @if($key==$search['member_type']) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salutation" class=" control-label">Member Overall Status</label>
                                        <select class="select2 form-control" name="status">
                                            <option value=''>Select status</option>
                                            @if (memberShipStatus())
                                                @foreach (memberShipStatus() as $key=>$item)
                                                    <option value="{{ $key }}"
                                                            @if($key==$search['status']) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">&emsp;&emsp;Find
                                    Member &emsp;&emsp;</button>
                                <a href="{{route('user.index')}}" class="btn btn-primary">&emsp;&emsp;Clear
                                    All &emsp;&emsp;</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{ url('admin/user/create') }}" class="btn btn-primary pull-right">Create</a>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Email</th>
                                <th>Overall Status</th>
                                <th>Subscription Status</th>
                                <th>Newsletter Subscription</th>
                                <th>Last&nbsp;Login</th>
                                <th>No of Login Attempts (12 Months)</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Member Type</th>
                                <th>Organization</th>
                                <th>Job Title</th>
                                <th>Mobile Number</th>
                                <th>Telephone Number</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Payment Status</th>
                                <th>Group Name</th>
                                <th>Registration Date</th>
                                <th>Subscription Date</th>
                                <th>Renewal Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($users->count())
                                @foreach($users as $user)
                                    <?php  $groupNames = memberGroupByUserIds($user->id); ?>
                                    <tr>
                                        <td>
                                            <table class="action-table">
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
                                            @if(!in_array($user->status,[__('constant.ACCOUNT_ACTIVE')]))

                                                <table class="action-table">
                                                    <tr>
                                                        <td>

                                                            <a class="update-status" title="Approve and send payment"
                                                               href="#"
                                                               data-member-type="{{$user->member_type}}"
                                                               data-user-id="{{$user->id}}" data-title="Approve and Send
                                                                Payment"
                                                               data-status="{{__('constant.PENDING_FOR_PAYMENT')}}">
                                                                <i class="fa fa-send btn btn-success"> Approve and Send
                                                                    Payment</i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="update-status" title="Approve" href="#"
                                                               data-member-type="{{$user->member_type}}"
                                                               data-user-id="{{$user->id}}" data-title="Approve"
                                                               data-status="{{__('constant.ACCOUNT_ACTIVE')}}">
                                                                <i class="fa fa-check btn btn-success"> Approve</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endif
                                            <table class="action-table">
                                                <tr>
                                                    <td>
                                                        <a class="" title="Reject"
                                                           onclick="return confirm('Are you sure to reject this user?')"
                                                           href="{{ route('update-status',['id'=>$user->id,'status'=>3]) }}">
                                                            <i class="fa fa-ban btn btn-danger"> Reject</i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(in_array($user->status,[__('constant.ACCOUNT_ACTIVE')]))
                                                            <a class="" title="Unsubscribe"
                                                               onclick="return confirm('Are you sure to unsubscribe this user?')"
                                                               href="{{ route('update-status',['id'=>$user->id,'status'=>11]) }}">
                                                                <i class="fa fa-bell-slash btn btn-danger">
                                                                    Unsubscribe</i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>


                                        </td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{memberShipStatus($user->status)}}</td>
                                        <td>@if($user->status==5)Active @else Inactive @endif</td>
                                        <td>{{($user->subscribe_status==1)?'Yes':'No'}}</td>
                                        <td data-sort="@if(user_last_login_date($user->id)) {{ strtotime(user_last_login_date($user->id)) }} @endif">@if(user_last_login_date($user->id)) {{ date('d M, Y h:i A', strtotime(user_last_login_date($user->id))) }} @else - @endif</td>
                                        <td align="center" valign="bottom"><a title="View Log" href="{{ url('admin/user/log-status/' . $user->id) }}">{!!user_total_no_login($user->id)!!}</a></td>
                                        <td>{{ $user->firstname ?? '-' }}</td>
                                        <td>{{ $user->lastname ?? '-' }}</td>
                                        <td>
                                            {{memberType($user->member_type)}}
                                        </td>
                                        <td>{{ $user->organization ?? '-' }}</td>
                                        <td>{{ $user->job_title ?? '-' }}</td>
                                        <td>
                                            @if($user->mobile_number)
                                                @if($user->mobile_code)
                                                    {{ '+'.$user->mobile_code}}
                                                @endif
                                                &nbsp;{{$user->mobile_number ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->telephone_number)
                                                @if($user->telephone_code)
                                                    {{ '+'.$user->telephone_code}}
                                                @endif
                                                &nbsp;{{$user->telephone_number ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $user->country ?? '-' }}</td>
                                        <td>{{ $user->city ?? '-' }}</td>
                                        <td>
                                            @if(!is_null($user->expired_at))
                                                @if(date('Y-m-d')<date('Y-m-d',strtotime($user->expired_at)))
                                                    Paid
                                                @else
                                                    Unpaid
                                                @endif
                                            @elseif(is_null($user->expired_at) && $user->status==5)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                            $groupNames = $groupNames->pluck('group_name')->all();
                                            ?>
                                            @if(count($groupNames))
                                                {{implode(',',$groupNames)}}
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td data-order="{{ $user->created_at }}">{{ $user->created_at->format('d M, Y h:i A') ?? '-' }}</td>
                                        <td data-order="<?php if (!is_null($user->invoice())) {
                                            echo $user->invoice()->created_at->format('d M, Y H:i:s');
                                        }?>">
                                            @if(!is_null($user->invoice()))
                                                @if(!is_null($user->invoice()->created_at))

                                                    {{ $user->invoice()->created_at->format('d M, Y')}}

                                                @else
                                                    -
                                                @endif
                                           {{-- @elseif(is_null($user->invoice()) && $user->status==5)
                                                @if(!is_null($user->renew_at))
                                                    {{ date('d M, Y',strtotime($user->renew_at))}}
                                                @else
                                                    -
                                                @endif--}}

                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-order="{{ $user->expired_at }}">
                                            @if(!is_null($user->expired_at) )
                                                {{date('d M, Y', strtotime($user->expired_at))}}
                                            @elseif(is_null($user->expired_at) && $user->status==5)
                                                Lifetime Validity
                                            @else - @endif
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
            <form action="{{ route('update-status') }}" method="GET">
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
                                        <select class="form-control select2" name="member_type" id="member-type"
                                                style="width: 100%">
                                            @if (memberType())
                                                @foreach (memberType() as $key=>$member)
                                                    <option value="{{ $key }}">{{ $member }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" name="status" value="" id="status">
                                        <input type="hidden" name="id" value="" id="user-id">
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary button-title">Approve and send payment link
                            </button>
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

    $('.update-status').click(function () {

        var memberType = $('#member-type');

        memberType.val($(this).data('member-type'));

        memberType.change();

        $('#status').val($(this).data('status'));

        $('#user-id').val($(this).data('user-id'));

        $(".button-title").html($(this).data('title'));

        $('#payment-approve-modal').modal('show');

    });



    $('#users').DataTable({

        dom: 'Bfrtip',

        'order': [

            [18, 'desc']

        ],

        "aoColumnDefs": [{

            "aTargets": [17],

            "bSortable": false

        },

            {

                width: 100,

                targets: 4

            },

            {

                width: 300,

                targets: 5

            },

            {

                width: 300,

                targets: 6

            },

            {

                width: 150,

                targets: 7

            },

            {

                width: 150,

                targets: 8

            },

            {

                width: 150,

                targets: 10

            }



        ],

        buttons: [

            {

                extend: 'excel',

                footer: true,

                exportOptions: {

                    columns: [1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]

                },

                filename: function () {

                    var today = new Date();

                    var dd = today.getDate();

                    var mm = today.getMonth() + 1; //January is 0!

                    var yyyy = today.getFullYear();

                    var yy = yyyy.toString().substring(2);

                    if (dd < 10) {

                        dd = '0' + dd

                    }

                    if (mm < 10) {

                        mm = '0' + mm

                    }

                    today = yy + '' + mm + '' + dd;

                    return 'Members - ' + today;

                }

            }

        ]

    });

    $(document).ready(function () {

        $("div.chart").addClass("collapsed-box");

    });





</script>

@endpush

