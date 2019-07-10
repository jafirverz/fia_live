@extends('admin.layout.app') @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        {{ $title }}
    </h1> {{ Breadcrumbs::render('student_edit', $student->id) }}
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
                    {!! Form::open(['url' => ['admin/student/update', $student->id], 'method' => 'post']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label>Title <span class="txt-red">*</span></label>
                                <select name="student_title" class="form-control">
                                    @foreach(StudentTitle() as $value)
                                    <option value="{{ $value }}" @if($student->student_title==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Student ID</label>
                                <input type="text" class="form-control" name="student_id" value="{{ $student->student_id ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" value="">
                            </div>
                            <div class="form-group">
                                <label>Name <span class="txt-red">*</span></label>
                                <input name="student_name" type="text" class="form-control" value="{{ $student->student_name ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth <span class="txt-red">*</span></label>
                                <div class="input-group date datepicker" id="DOB">
                                    <input name="student_dob" type="text" class="form-control" placeholder="Date of Birth" value="{{ date('Y-m-d', strtotime($student->student_dob)) }}" autocomplete="off">
                                    <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gender <span class="txt-red">*</span></label>
                                <select name="student_gender" class="form-control">
                                    @foreach(gender() as $key => $value)
                                    <option value="{{ $key }}" @if($student->student_gender==$key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nationality <span class="txt-red">*</span></label>
                                <select name="student_nationality" class="form-control">
                                    @foreach(nationality() as $value)
                                    <option value="{{ $value }}" @if($student->student_nationality==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input name="student_nationality_other" type="text" class="form-control" placeholder="Please Specify" value="{{ $student->student_nationality_other ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Race <span class="txt-red">*</span></label>
                                <select name="race" class="form-control">
                                    @foreach(race() as $value)
                                    <option value="{{ $value }}" @if($student->race==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input name="race_other" type="text" class="form-control" placeholder="Please Specify" value="{{ $student->race_other ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Religion <span class="txt-red">*</span></label>
                                <select name="religion" class="form-control">
                                    @foreach(religion() as $value)
                                    <option value="{{ $value }}" @if($student->religion==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input name="religion_other" type="text" class="form-control" placeholder="Please Specify" value="{{ $student->religion_other ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Marital Status <span class="txt-red">*</span></label>
                                <select name="marital_status" class="form-control">
                                    @foreach(marital_status() as $key => $value)
                                    <option value="{{ ($key+1) }}" @if($student->marital_status==($key+1)) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Occupation <span class="txt-red">*</span></label>
                                <input name="occupation" type="text" class="form-control" value="{{ $student->occupation ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Highest Education Level <span class="txt-red">*</span></label>
                                <input name="higest_level_education" type="text" class="form-control" value="{{ $student->higest_level_education ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Telephone <span class="txt-red">*</span></label>
                                <input name="telephone" type="text" class="form-control" value="{{ $student->telephone ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Personal Email <span class="txt-red">*</span></label>
                                <input name="student_email" type="text" class="form-control" value="{{ $student->student_email ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Blk No. <span class="txt-red">*</span></label>
                                <input name="blk_no" type="text" class="form-control" value="{{ $student->blk_no ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Unit No. <span class="txt-red">*</span></label>
                                <input name="unit_no" type="text" class="form-control" value="{{ $student->unit_no ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Building/ Street Name <span class="txt-red">*</span></label>
                                <input name="building_street_name" type="text" class="form-control" value="{{ $student->building_street_name ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Country <span class="txt-red">*</span></label>
                                <select name="country" class="form-control">
                                    @foreach(countryList() as $value)
                                    <option value="{{ $value }}" @if($student->country==$value) selected @elseif($value=='Singapore') selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Postal Code <span class="txt-red">*</span></label>
                                <input name="postal_code" type="text" class="form-control" value="{{ $student->postal_code ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="nric_passport" value="nric" @if($student->nric_passport=='nric') checked @else checked @endif>
                                    NRIC
                                </label>
                                <label class="radio-inline">
                                    <input id="r2" type="radio" name="nric_passport" value="passport" @if($student->nric_passport=='passport') checked @endif>
                                    Passport No.
                                </label>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input name="nric_passport_no" type="text" class="form-control" value="{{ $student->nric_passport_no ?? '' }}">
                                    @if ($errors->has('nric_passport_no'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('nric_passport_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group passport_issuance_country">
                                <label>Passport Issuance Country <span class="txt-red">*</span></label>
                                <select name="passport_issuance_country" class="form-control" data-width="100%" data-style="" title="-- Select --">
                                    @foreach(countryList() as $value)
                                    <option value="{{ $value }}" @if($student->passport_issuance_country==$value) selected @elseif($value=='Singapore') selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group passport_expiry_date">
                                <label>Passport Expiry Date <span class="txt-red">*</span></label>
                                <div class="input-group date datepicker" id="DOB">
                                    <input name="passport_expiry_date" type="text" class="form-control" placeholder="Passport Expiry Date" value="{{ $student->passport_expiry_date }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Church <span class="txt-red">*</span></label>
                                <select name="church" class="form-control">
                                    @foreach(church() as $value)
                                    <option value="{{ $value }}" @if($student->church==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input name="church_other" type="text" class="form-control" placeholder="Please Specify" value="{{ $student->church_other ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Denomination <span class="txt-red">*</span></label>
                                <select name="denomination" class="form-control">
                                    @foreach(denomination() as $value)
                                    <option value="{{ $value }}" @if($student->denomination==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <input name="denomination_other" type="text" class="form-control" placeholder="Please Specify" value="{{ $student->denomination_other ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Applicant Type <span class="txt-red">*</span></label>
                                <select name="applicant_type" class="form-control">
                                    @foreach(applicant_type() as $value)
                                    <option value="{{ $value }}" @if($student->applicant_type==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>How did you find out about BGST <span class="txt-red">*</span></label>
                                <select name="find_out_about" class="form-control">
                                    @foreach(find_out_about() as $value)
                                    <option value="{{ $value }}" @if($student->find_out_about==$value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $("select[name='student_nationality'], select[name='race'], select[name='religion'], select[name='church'], select[name='denomination'], input[name='nric_passport_no']").trigger("change");
        });

        $("select[name='student_nationality'], select[name='race'], select[name='religion'], select[name='church'], select[name='denomination']").on("change", function() {
            $(this).parents("div.form-group").find("input").addClass("hide");
            if($(this).val()=='Other')
            {
                $(this).parents("div.form-group").find("input").removeClass("hide");
            }
            else
            {
                $(this).parents("div.form-group").find("input").val('');
            }
        });

        $("input[name='nric_passport_no']").on("change", function() {
            $(".passport_issuance_country, .passport_expiry_date").addClass("hide");
            value = $("input[name='nric_passport_no']:checked").val();
            if(value=='passport')
            {
                $(".passport_issuance_country, .passport_expiry_date").removeClass("hide");
            }
            else
            {
                $(".passport_issuance_country, .passport_expiry_date").val('');
            }
        });
    });
</script>
@endsection
