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

    public function index()
    {
        $title = __('constant.USER');
        $subtitle = 'Index';


        $search = [];
        $search['name'] = null;
        $search['organization'] = null;
        $search['email'] = null;
        $search['member_type'] = null;
        $search['status'] = null;
        $result = $this->members($search);
        $users = $result['users'];
        return view('admin.users.index', compact('title', 'users', 'subtitle', 'search'));
    }

    /**
     *
     */
    public function search(Request $request)
    {
        $title = __('constant.USER');
        $subtitle = 'Index';
        $search = $request->all();
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
        $user = New User();
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
        $users = User::where('subscribe_status', 1)->where('email','nikunj@verzdesign.com')->get();
        $today_date = Carbon::now();
        $beforeWeek =Carbon::now()->addDay(-7);
        $weekly = $beforeWeek->format('Y-m-d');
        $today_date = Carbon::now();

        $weeklyRegulatories = Regulatory::where('parent_id', '!=', null)->whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
        //dd(DB::getQueryLog());
        //dd($weeklyRegulatories->count());
        $content = [];
        foreach($weeklyRegulatories as $regulatory)
        {
            $value = getRegulatoryData($regulatory->parent_id);
            if($value)
            {
                $content[] = '<tr>
								<td style="text-align: left; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;"><p style="color: #017cba; "><b>'.$regulatory->title.'</b></p><p>'.Str::limit($regulatory->description, 100).'<a href="'.url('regulatory-details', $value->slug) . '?id=' . $regulatory->id.'" target="_blank" style="color: #f48120; text-decoration:none; "> <b>Read More&nbsp;&#x226B;</b></a></p></td></tr>';
            }
        }

        if ($content) {
            $emailTemplate_user = $this->emailTemplate(__('constant.END_DAY_REPORT'));
            if ($emailTemplate_user) {
                $content_data = implode(' ', $content);
                $email_template_logo = '<img  src="'.asset(setting()->email_template_logo).'" alt="">';
                $contact = '<a href="mailto:regulatory@foodindustry.asia" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" src="'.asset('photos/2/icon6.jpg').'"></a>';
                $linkedin = '<a href="'.setting()->linkedin_link.'" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="'.asset('photos/2/icon5.jpg').'"></a>';
                $twitter = '<a href="'.setting()->twitter_link.'" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="'.asset('photos/2/icon2.jpg').'"></a>';
                $users = ['desmond.lau@foodindustry.asia','monwai@verzdesign.com','nikunj@verzdesign.com'];
                foreach ($users as $user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $unsubscribe = '<a style="color:#999" href="'.url('unsubscribe?id='.base64_encode($user)).'" target="_blank">unsubscribe</a>';
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{logo}}','{{contact}}', '{{linkedin}}', '{{twitter}}', '{{content}}','{{unsubscribe}}'];
                    $value_user = [$email_template_logo,$contact, $linkedin, $twitter, $content_data,$unsubscribe];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user)->queue(new RegulatoryUpdates($data_user));
                        //dd($user);
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }
            }
        }
        dd($weeklyRegulatories->count());
    }


}
