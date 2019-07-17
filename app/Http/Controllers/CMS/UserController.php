<?php

namespace App\Http\Controllers\CMS;

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
        $users = User::orderBy('created_at','desc')->get();
        return view('admin.users.index', compact('title', 'users', 'subtitle'));
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
        $user->password = Hash::make($request->password);
        if (isset($request->status) && !is_null($request->status)) {
            $user->status = $request->status;
        } else {
            $user->status = 1;
        }
        $user->save();

        if (isset($request->group_ids) && count($request->group_ids)) {
            foreach ($request->group_ids as $groupId) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $user->id;
                $groupUserId->group_id = $groupId;
                $groupUserId->save();
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
            'email' => 'required|unique:users,email,'. $id,
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
        $user->status = 9 ;
        $user->save();
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
        $user = User::findorfail($request->user_id);
        if ($request->status == __('constant.PENDING_EMAIL_VERIFICATION')) {
            $user->status = __('constant.PENDING_EMAIL_VERIFICATION');
            $response['msg'] = "Status updated and verification mail send to user.";

        } elseif ($request->status == __('constant.PENDING_ADMIN_APPROVAL')) {
            $user->status = __('constant.PENDING_ADMIN_APPROVAL');
            $response['msg'] = "Status updated successfully.";


        } elseif ($request->status == __('constant.REJECTED')) {
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

            }

            try {
                $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                //dd($exception);
                $response['msg'] = "Status updated successfully.";
                $response['status'] = "error";
                return $response;
            }

            $user->member_type = $request->member_type;
            $user->status = __('constant.PENDING_FOR_PAYMENT');
            $response['msg'] = "Status updated successfully.";

        } elseif ($request->status == __('constant.ACCOUNT_ACTIVE')) {
            $user->member_type = $request->member_type;
            $user->status = __('constant.ACCOUNT_ACTIVE');
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
}
