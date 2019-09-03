@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('user_edit',$user->id) }}
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

                    <form name="user" method="post" action="{{ url('/admin/user/update',$user->id)}}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="salutation" class=" control-label">Salutation</label>
                                <select class="select2 form-control" name="salutation">
                                    <option value="">Select Salutation</option>
                                    @if (salutation())
                                        @foreach (salutation() as $item)
                                            <option value="{{ $item }}" @if($item==$user->salutation) selected @endif>
                                                {{ $item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="firstname" class=" control-label">First Name</label>
                                <input class="form-control" placeholder="" value="{{ $user->firstname }}"
                                       name="firstname" type="text" id="">
                            </div>

                            <div class="form-group">
                                <label for="lastname" class=" control-label">Last Name</label>
                                <input class="form-control" placeholder="" value="{{ $user->lastname }}" name="lastname"
                                       type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="email" class=" control-label">Email</label>
                                <input class="form-control " placeholder="" value="{{ $user->email }}"
                                       name="email" type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="member_type" class=" control-label">Member Type</label>
                                <select class="form-control select2" name="member_type">
                                    @if (memberType())
                                        @foreach (memberType() as $key=>$member)
                                            <option value="{{ $key }}"
                                                    @if($key==$user->member_type) selected
                                                    @endif>{{ $member }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="organization" class="control-label">Organisation</label>
                                <input class="form-control" placeholder="" value="{{ $user->organization }}"
                                       name="organization" type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="job_title" class=" control-label">Job Title</label>
                                <input class="form-control " placeholder="" value="{{ $user->job_title }}"
                                       name="job_title" type="text" id="">
                            </div>

                            <div class="form-group">
                                <label for="" class=" control-label">Telephone Number</label>

                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control countries" name="telephone_code">
                                            @if (CountryList())
                                                @foreach (CountryList() as $item)
                                                    <option value="{{ $item->phonecode }}" data-iso="{{$item->iso}}"
                                                            @if($item->phonecode==$user->telephone_code) selected @endif>
                                                        &nbsp;+{{ $item->phonecode }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="" value="{{ $user->telephone_number }}"
                                               name="telephone_number" type="text" id="payee_name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class=" control-label">Mobile Number</label>

                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control countries" name="mobile_code">
                                            @if (CountryList())
                                                @foreach (CountryList() as $item)
                                                    <option value="{{ $item->phonecode }}" data-iso="{{$item->iso}}"
                                                            @if($item->phonecode==$user->mobile_code) selected @endif>
                                                        &nbsp;+{{ $item->phonecode }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="" value="{{ $user->mobile_number }}"
                                               name="mobile_number" type="text" id="mobile_number">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country" class=" control-label">Country</label>
                                <select class="form-control select2" name="country">
                                    @if (CountryList())
                                        @foreach (CountryList() as $item)
                                            <option value="{{ $item->country }}"
                                                    @if($item->country==$user->country) selected
                                                    @endif>{{ $item->country }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city" class=" control-label">City</label>
                                <input class="form-control " placeholder="" value="{{ $user->city }}"
                                       name="city" type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="address1" class=" control-label">Address line 1</label>
                                <input class="form-control " placeholder="" value="{{ $user->address1 }}"
                                       name="address1" type="text" id="">
                            </div>
                            <div class="form-group">
                                <label for="address2" class=" control-label">Address line 2</label>
                                <input class="form-control " placeholder="" value="{{ $user->address2 }}"
                                       name="address2" type="text" id="">
                            </div>
                            <?php
                            $groupIds = memberGroupByUserIds($user->id);
                            $groupIds = $groupIds->pluck('group_id')->all();
                            ?>
                            <div class="form-group">
                                <label for="group_ids" class=" control-label">Group</label>
                                <select class="form-control select2" name="group_ids[]" multiple="multiple"
                                        data-placeholder="-- Select a group --" style="width: 100%;">
                                    <option value="">-- Select Group --</option>
                                    @if (memberGroup())
                                        @foreach (memberGroup() as $key=>$group)
                                            <option value="{{ $group->id }}"
                                                    @if(in_array($group->id,$groupIds)) selected="selected" @endif>{{ $group->group_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password" class=" control-label">Password</label>
                                <input class="form-control " placeholder="" value=""
                                       name="password" type="password" id="">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class=" control-label">Confirm Password</label>
                                <input class="form-control " placeholder="" value=""
                                       name="password_confirmation" type="password" id="">
                            </div>
                            <div class="form-group">
                                    <label class="checkbox-inline"><input type="checkbox" id="update" name="subscribe_status"
                                        value="1" @if($user->subscribe_status==1) checked @endif /> I’d like to subscribe to the FIA Regulatory Hub newsletter to receive the latest regulatory updates.</label>
                            </div>
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>

                                <select name="status" class="form-control select2" id="selectpicker"
                                        data-placeholder="Select Status">
                                    @foreach(memberShipStatus() as $k => $v)
                                        <option value="{{$k}}" @if($user->status==$k) selected @endif>{{$v}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>

                        </div>
                    </form>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('header-script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
@endpush
@push('scripts')
<script id="script_e4">
    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var iso = item.element.dataset.iso;
        var img = $("<img>", {
            class: "img-flag",
            width: 26,
            src: APP_URL + '/flags_iso/24/' + iso.toLowerCase() + '.svg'
        });
        var span = $("<span>", {
            text: " " + item.text
        });
        span.prepend(img);
        return span;
    }

    $(document).ready(function () {
        $(".countries").select2({
            templateResult: function (item) {
                return format(item, false);
            }
        });
    });

</script>
@endpush
