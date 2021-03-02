<?php

namespace App\Http\Controllers\CMS;

use App\Mail\RegulatoryUpdates;
use App\Regulatory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Traits\GetEmailTemplate;
use Exception;
use App\Mail\UserSideMail;
use Auth;
use App\GroupUserId;
use App\Podcast;
use App\ThinkingPiece;
use App\TopicalReport;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;


class UserController extends Controller
{
    use GetEmailTemplate;

    public function __construct()
    {

        $this->middleware('auth:admin');
        $this->module_name = 'USER';
    }

    public function index(Request $request)
    {
        $title = __('constant.USER');
        $subtitle = 'Index';
        $search = [];
        $search['name'] = $request->name ?? "";
        $search['organization'] = $request->organization ?? "";
        $search['email'] = $request->email ?? "";
        $search['member_type'] = $request->member_type ?? "";
        $search['status'] = $request->status ?? "";
        $result = $this->members($search);
        $users = $result['users'];

        return view('admin.users.index', compact('title', 'users', 'subtitle', 'search'));
    }

    public function log_status($id)
    {


        $user = User::findorfail($id);
        $title = $user->firstname . ' ' . $user->lastname;
        $subtitle = 'Log';
        $users = DB::table('authentication_log')->where('authenticatable_id', $id)->where('login_at', '<=', Carbon::now())->where('login_at', '>=', Carbon::now()->subMonth(12))->where('authenticatable_type', 'like', '%User%')->get();
        return view('admin.users.log', compact('title', 'users', 'subtitle'));
    }


    /**
     *
     */
    public function search(Request $request)
    {
        
        $title = __('constant.USER');
        $subtitle = 'Index';
        $search = [];
        $search['name'] = $request->name ?? "";
        $search['organization'] = $request->organization ?? "";
        $search['email'] = $request->email ?? "";
        $search['member_type'] = $request->member_type ?? "";
        $search['status'] = $request->status ?? "";
        $result = $this->members($search);
        $users = $result['users'];

        return view('admin.users.index', compact('title', 'users', 'subtitle', 'search'));
    }

    public function members($search)
    {
        $result = [];
        $query = User::query();
        if ($search['name']) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', '%' . $search['name'] . '%')
                    ->orWhere('lastname', 'like', '%' . $search['name'] . '%');
            });
        }
        if ($search['organization']) {
            $query->where('organization', 'like', '%' . $search['organization'] . '%');
        }
        if ($search['email']) {
            $query->where('email', 'like', '%' . $search['email'] . '%');
        }
        if ($search['member_type']) {
            $query->where('member_type', $search['member_type']);
        }
        if ($search['status']) {
            $query->where('status', $search['status']);
        }
        $result['users'] = $query->orderBy('created_at', 'desc')->get();
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.USER');
        $subtitle = 'Create';

        return view('admin.users.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'member_type' => 'required',
            'organization' => 'required|string',
            'password' => 'required|confirmed',
            'country' => 'required',
            'status' => 'required',
        ]);
        $user_id = guid();
        $user = new User();
        $user->user_id = $user_id;
        $user->salutation = $request->salutation;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->member_type = $request->member_type;
        $user->country = $request->country;
        $user->organization = $request->organization;
        $user->job_title = $request->job_title;
        $user->telephone_code = $request->telephone_code;
        $user->telephone_number = $request->telephone_number;
        $user->mobile_code = $request->mobile_code;
        $user->mobile_number = $request->mobile_number;
        $user->city = $request->city;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->subscribe_status = $request->subscribe_status ?? null;
        $user->save();

        if (isset($request->group_ids) && count($request->group_ids)) {
            foreach ($request->group_ids as $groupId) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $user->id;
                $groupUserId->group_id = $groupId;
                $groupUserId->save();
            }
        }

        if ($user->status == __('constant.PENDING_FOR_PAYMENT')) {

            $emailTemplate_user = $this->emailTemplate(__('constant.SEND_PAYMENT_LINK'));
            if ($emailTemplate_user) {

                $data_user = [];
                $data_user['subject'] = $emailTemplate_user->subject;
                $data_user['email_sender_name'] = setting()->email_sender_name;
                $data_user['from_email'] = setting()->from_email;
                $data_user['subject'] = $emailTemplate_user->subject;
                $key_user = ['{{firstname}}'];
                $value_user = [$user->firstname];
                $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                $data_user['contents'] = $newContents_user;
            }

            try {
                $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                //dd($exception);
            }
        }

        return redirect('admin/user')->with('success', __('constant.CREATED', ['module' => __('constant.USER')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('constant.USER');
        $subtitle = 'Edit';
        $user = User::findorfail($id);

        return view('admin.users.edit', compact('title', 'subtitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'member_type' => 'required',
            'organization' => 'required|string',
            'password' => 'confirmed',
            'country' => 'required',
            'status' => 'required',
        ]);
        $user = User::findorfail($id);
        $user->salutation = $request->salutation;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->member_type = $request->member_type;
        $user->country = $request->country;
        $user->organization = $request->organization;
        $user->job_title = $request->job_title;
        $user->telephone_code = $request->telephone_code;
        $user->telephone_number = $request->telephone_number;
        $user->mobile_code = $request->mobile_code;
        $user->mobile_number = $request->mobile_number;
        $user->city = $request->city;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->password = Hash::make($request->password);
        if (isset($request->status) && !is_null($request->status)) {
            $user->status = $request->status;
        }
        $user->subscribe_status = $request->subscribe_status ?? null;
        $user->save();

        if (isset($request->group_ids) && count($request->group_ids)) {
            $groups = GroupUserId::where('user_id', $id)->delete();
            foreach ($request->group_ids as $groupId) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $user->id;
                $groupUserId->group_id = $groupId;
                $groupUserId->save();
            }
        }
        if (isset($request->subscribe_status) && $request->subscribe_status == 1) {
            $emailTemplate_user = $this->emailTemplate(__('constant.SUBSCRIPTION_ADMIN_TO_USER_EMAIL_TEMP_ID'));
            if ($emailTemplate_user) {

                $data_user = [];
                $data_user['subject'] = $emailTemplate_user->subject;
                $data_user['email_sender_name'] = setting()->email_sender_name;
                $data_user['from_email'] = setting()->from_email;
                $data_user['subject'] = $emailTemplate_user->subject;
                $key_user = ['{{firstname}}'];
                $value_user = [$user->firstname];
                $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                $data_user['contents'] = $newContents_user;
            }

            try {
                $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                //dd($exception);
            }
        }

        $response = $this->userUpdateStatus($request);

        return redirect('admin/user')->with('success', __('constant.UPDATED', ['module' => __('constant.USER')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $title = __('constant.USER');
        $subtitle = 'View';
        $user = User::findorfail($id);

        return view('admin.users.view', compact('title', 'subtitle', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->delete();
        return redirect('admin/user')->with('success', __('constant.DELETED', ['module' => __('constant.USER')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $response = $this->userUpdateStatus($request);

        return redirect('admin/user')->with($response['status'], $response['msg']);
    }

    public function userUpdateStatus($request)
    {
        $response = [];
        $user = User::findorfail($request->id);
        if ($request->status == __('constant.PENDING_EMAIL_VERIFICATION')) {
            $user->status = __('constant.PENDING_EMAIL_VERIFICATION');
            $response['msg'] = "Status updated and verification mail send to user.";
        } elseif ($request->status == __('constant.PENDING_ADMIN_APPROVAL')) {
            $user->status = __('constant.PENDING_ADMIN_APPROVAL');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.REJECTED')) {
            $emailTemplate_user = $this->emailTemplate(__('constant.USER_REGISTRATION_REJECTED'));
            if ($emailTemplate_user) {

                $data_user = [];
                $data_user['subject'] = $emailTemplate_user->subject;
                $data_user['email_sender_name'] = setting()->email_sender_name;
                $data_user['from_email'] = setting()->from_email;
                $data_user['subject'] = $emailTemplate_user->subject;
                $key_user = ['{{name}}', '{{email}}'];
                $value_user = [$user->firstname, $user->email];
                $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                $data_user['contents'] = $newContents_user;
            }

            try {
                $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                //dd($exception);
                $response['msg'] = "Status updated successfully.";
                $response['status'] = "error";
                return $response;
            }
            $user->status = __('constant.REJECTED');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.PENDING_FOR_PAYMENT')) {

            $emailTemplate_user = $this->emailTemplate(__('constant.SEND_PAYMENT_LINK'));
            if ($emailTemplate_user) {

                $data_user = [];
                $data_user['subject'] = $emailTemplate_user->subject;
                $data_user['email_sender_name'] = setting()->email_sender_name;
                $data_user['from_email'] = setting()->from_email;
                $data_user['subject'] = $emailTemplate_user->subject;
                $key_user = ['{{firstname}}'];
                $value_user = [$user->firstname];
                $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                $data_user['contents'] = $newContents_user;
                try {
                    $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                } catch (Exception $exception) {
                    //dd($exception);
                    $response['msg'] = "Status updated successfully.";
                    $response['status'] = "error";
                    return $response;
                }
            }


            $user->member_type = $request->member_type;
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now()->toDateTimeString();
            }
            $user->status = __('constant.PENDING_FOR_PAYMENT');
            $user->renew_status = 0;
            $user->renew_at = Carbon::now()->toDateTimeString();
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.ACCOUNT_ACTIVE')) {
            $user->member_type = $request->member_type;
            $user->status = __('constant.ACCOUNT_ACTIVE');
            $user->expired_at = null;

            $emailTemplate_user = $this->emailTemplate(__('constant.USER_ACCOUNT_APPROVED'));
            if ($emailTemplate_user) {

                $data_user = [];
                $data_user['subject'] = $emailTemplate_user->subject;
                $data_user['email_sender_name'] = setting()->email_sender_name;
                $data_user['from_email'] = setting()->from_email;
                $data_user['subject'] = $emailTemplate_user->subject;
                $key_user = ['{{name}}'];
                $value_user = [$user->firstname];
                $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                $data_user['contents'] = $newContents_user;
                try {
                    $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                } catch (Exception $exception) {
                    //dd($exception);
                    $response['msg'] = "Status updated successfully.";
                    $response['status'] = "error";
                    return $response;
                }
            }

            if (empty($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now()->toDateTimeString();
            }
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.ACCOUNT_INACTIVE')) {
            $user->status = __('constant.ACCOUNT_INACTIVE');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.ACCOUNT_LAPSED')) {
            $user->status = __('constant.ACCOUNT_LAPSED');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.ACCOUNT_EXPIRED')) {
            $user->status = __('constant.ACCOUNT_EXPIRED');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.ACCOUNT_DELETED')) {
            $user->status = __('constant.ACCOUNT_DELETED');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.NEWSLATTER_SUBSCRIBER')) {
            $user->status = __('constant.NEWSLATTER_SUBSCRIBER');
            $response['msg'] = "Status updated successfully.";
        } elseif ($request->status == __('constant.UNSUBSCRIBE')) {
            $user->status = __('constant.UNSUBSCRIBE');
            $response['msg'] = "Status updated successfully.";
        }
        $response['status'] = "success";
        $user->save();
        return $response;
    }

    public function userStatusExpired(Request $request)
    {

        $users = User::whereDate('expired_at', '<', date('Y-m-d'))->where('status', [__('constant.ACCOUNT_ACTIVE')])->get();
        $newUsers = User::whereDate('renew_at', '<', Carbon::now()->add(-3, 'month')->format('Y-m-d'))->where('renew_status', 0)->where('status', __('constant.PENDING_FOR_PAYMENT'))->get();
        if ($users->count()) {
            foreach ($users as $user) {
                $user->status = __('constant.ACCOUNT_EXPIRED');
                $user->renew_status = 3;
                $user->renew_at = Carbon::now()->toDateTimeString();
                $user->save();
            }
        }

        if ($newUsers->count()) {
            foreach ($newUsers as $user) {
                $user->status = __('constant.ACCOUNT_LAPSED');
                $user->renew_status = 0;
                $user->renew_at = Carbon::now()->toDateTimeString();
                $user->save();
            }
        }
    }

    public function weeklyReport()
    {
        //DB::enableQueryLog();
        $users = User::where('subscribe_status', 1)->get();
        $today_date = Carbon::now();
        $beforeWeek = Carbon::now()->addDay(-7);
        $beforeMonth = Carbon::now()->subMonth();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $weekly = $beforeWeek->format('Y-m-d');
        $startOfMonthDate = $startOfMonth->format('Y-m-d');
        $endOfMonthDate = $endOfMonth->format('Y-m-d');
        $today_date = Carbon::now();
        $weeklyRegulatories = Regulatory::where('parent_id', '!=', null)->whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();

        $weeklyTopicalReports = TopicalReport::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();

        //Podcast update we will send for whole month repeat in every week.
        $weeklyPodcasts = Podcast::whereDate('created_at', '>=', $startOfMonthDate)->whereDate('created_at', '<=', $endOfMonthDate)->latest()->limit(10)->get();

        $weeklyThinkingPiece = ThinkingPiece::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
        //dd(DB::getQueryLog());
        $content = [];
        if ($weeklyPodcasts->count()) {
            $i = 0;
            $len = $weeklyPodcasts->count();
            $content[] = '<tr><td>';
            foreach ($weeklyPodcasts->sortByDesc('created_at') as $podcast) {

                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Podcast</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
														<tbody> 
															<tr>
																<td style="padding-top:5px;"><img src="' . asset($podcast->thumb_image) . '" alt="" width="120px" /></td>
																<td style="padding-top:5px;"><img src="' . asset('images/tempt/blank.png') . '" alt="" style="width:30px" /></td>
																<td style="padding-top:5px;">
                                                                <p style="color: #017cba;font-family: Arial !important;padding-top:10px; "><b>' . date('M Y', strtotime($podcast->created_at)) . ' | </b>' . ucfirst($podcast->title) . '</p>
                                                                <p style="color: #000000;font-family: Arial !important;padding-top:10px; ">';
                if (strlen($podcast->description) > 50) {
                    $content[] = substr($podcast->description, 0, 50) . '...';
                } else {
                    $content[] =  $podcast->description;
                }
                $content[] = '</p>
                                                                <p style="text-align:right"><a href="' . url('podcast') . '?id=' . $podcast->id . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Listen Now</b></a></p>
																</td>
															</tr> 
														</tbody>
													</table> 
                                    
                                    </td>
                                </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }
        if ($weeklyRegulatories->count()) {
            $content[] = '<tr><td>';
            $i = 0;
            $len = $weeklyRegulatories->count();
            foreach ($weeklyRegulatories->sortByDesc('regulatory_date') as $regulatory) {
                $value = getRegulatoryData($regulatory->parent_id);
                if ($value) {
                    if ($i == 0) {
                        $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                        $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Regulatory Issues</p>
                                                </td>
                                            </tr>';
                    }
                    $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important;"><b>' . date('d M Y', strtotime($regulatory->regulatory_date)) . ' | </b>' . ucfirst($regulatory->title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('regulatory-details', $value->slug) . '?id=' . $regulatory->id . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if ($i == ($len - 1)) {
                        $content[] = '</tbody>
                        </table>';
                    }
                }
                $i++;
            }
            $content[] = '</td></tr>';
        }

        if ($weeklyTopicalReports->count()) {
            $i = 0;
            $len = $weeklyTopicalReports->count();
            $content[] = '<tr><td>';
            foreach ($weeklyTopicalReports->sortByDesc('regulatory_date') as $topical) {

                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Topical Reports</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important;"><b>' . date('d M Y', strtotime($topical->created_at)) . ' | </b>' . ucfirst($topical->title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('topical-reports') . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }



        if ($weeklyThinkingPiece->count()) {
            $i = 0;
            $len = $weeklyThinkingPiece->count();
            $content[] = '<tr><td>';
            foreach ($weeklyThinkingPiece->sortByDesc('created_at') as $thinking) {
                $thinking_piece_title = str_replace(" ", "-", $thinking->thinking_piece_title);
                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Thinking Piece</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($thinking->created_at)) . ' | </b>' . ucfirst($thinking->thinking_piece_title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('thinking-piece/' . $thinking->slug) . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }
        //dd($content);

        if ($content) {
            $emailTemplate_user = $this->emailTemplate(__('constant.END_DAY_REPORT'));
            if ($emailTemplate_user) {
                $content_data = implode(' ', $content);
                $email_template_logo = '<img  src="' . asset(setting()->email_template_logo) . '" alt="">';
                $contact = '<a href="mailto:regulatory@foodindustry.asia" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" src="' . asset('photos/2/icon6.jpg') . '"></a>';
                $linkedin = '<a href="' . setting()->linkedin_link . '" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="' . asset('photos/2/icon5.jpg') . '"></a>';
                $twitter = '<a href="' . setting()->twitter_link . '" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="' . asset('photos/2/icon2.jpg') . '"></a>';
                foreach ($users as $user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $unsubscribe = '<a style="color:#999;font-family: Arial !important;" href="' . url('unsubscribe?id=' . base64_encode($user->email)) . '" target="_blank">unsubscribe</a>';
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{logo}}', '{{contact}}', '{{linkedin}}', '{{twitter}}', '{{content}}', '{{unsubscribe}}'];
                    $value_user = [$email_template_logo, $contact, $linkedin, $twitter, $content_data, $unsubscribe];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        //nikunj mail test
                        $mail_user = Mail::to('nikunj@verzdesign.com')->queue(new RegulatoryUpdates($data_user));
                        //user mail test
                        //$mail_user = Mail::to($user->email)->queue(new RegulatoryUpdates($data_user));
                    } catch (Exception $exception) {
                        //phpinfo(); exit;
                        dd($exception);
                    }

                    dd(count($users), 'sent ok!');
                }
            }
        }
    }
}
