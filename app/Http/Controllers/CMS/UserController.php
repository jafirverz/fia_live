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
use Carbon\Carbon;
use DB;


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
        $chart1 = $result['chart1'];
        $chart2 = $result['chart2'];
        $users = $result['users'];
        return view('admin.users.index', compact('title', 'users', 'subtitle', 'chart1', 'chart2', 'search'));
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
        $chart1 = $result['chart1'];
        $chart2 = $result['chart2'];
        $users = $result['users'];


        return view('admin.users.index', compact('title', 'users', 'subtitle', 'chart1', 'chart2', 'search'));
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

        $memberbycountry = User::get();

        $membership_growth_date = User::whereYear('created_at', date('Y'))->where('status', '!=', __('constant.NEWSLATTER_SUBSCRIBER'))->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), 'users.*')->groupby('new_date')->get();
        $membership_growth = User::whereYear('created_at', date('Y'))->where('status', '!=', __('constant.NEWSLATTER_SUBSCRIBER'))->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), 'users.*')->get();
        //dd($membership_growth->where('renew_status', 1)->where('new_date', '2019-07')->count());
        // CHART1
        $country_array = $memberbycountry->groupBy('country')->toArray();

        $fia_member_dataset = [];
        $member_dataset = [];
        $complimentary_dataset = [];
        $fia_member_dataset_color = [];
        $member_dataset_color = [];
        $complimentary_dataset_color = [];

        foreach (array_keys($country_array) as $value) {
            $fia_member_dataset[] = $memberbycountry->where('member_type', 1)->where('country', $value)->count();
            $fia_member_dataset_color[] = 'rgb(0,192,239)';
            $member_dataset[] = $memberbycountry->where('member_type', 2)->where('country', $value)->count();
            $member_dataset_color[] = 'rgb(60,141,188)';
            $complimentary_dataset[] = $memberbycountry->where('member_type', 3)->where('country', $value)->count();
            $complimentary_dataset_color[] = 'rgb(210,214,222)';
        }

        //CHART2
        $new_dataset = [];
        $expired_dataset = [];
        $renewed_dataset = [];
        foreach ($membership_growth_date as $value) {
            $new_dataset[] = $membership_growth->where('renew_status', 1)->where('new_date', $value->new_date)->count();
            $expired_dataset[] = $membership_growth->where('renew_status', 3)->where('new_date', $value->new_date)->count();
            $renewed_dataset[] = $membership_growth->where('renew_status', 2)->where('new_date', $value->new_date)->count();
        }
        $result['chart1'] = app()->chartjs
            ->name('memberbycountry')
            ->type('bar')
            ->size(['width' => 400, 'height' => 100])
            ->labels(array_keys($country_array))
            ->datasets([
                [
                    "label" => "FIA Member",
                    'backgroundColor' => $fia_member_dataset_color,
                    'data' => $fia_member_dataset
                ],
                [
                    "label" => "Member",
                    'backgroundColor' => $member_dataset_color,
                    'data' => $member_dataset
                ],
                [
                    "label" => "Complimentary",
                    'backgroundColor' => $complimentary_dataset_color,
                    'data' => $complimentary_dataset
                ]
            ])
            ->optionsRaw([
                'responsive' => true,
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => '#000'
                    ]
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'stacked' => true,
                            'gridLines' => [
                                'display' => true
                            ]
                        ]
                    ],
                    'yAxes' => [
                        [
                            'stacked' => true,
                            'gridLines' => [
                                'display' => true
                            ]
                        ]
                    ]
                ]
            ]);

        $result['chart2'] = app()->chartjs
            ->name('membershipgrowth')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels($membership_growth_date->pluck('new_date')->toArray())
            ->datasets([
                [
                    "label" => "New",
                    'borderColor' => ['rgb(251,189,11)'],
                    'data' => $new_dataset
                ],
                [
                    "label" => "Expired",
                    'borderColor' => ['rgb(234,67,53)'],
                    'data' => $expired_dataset
                ],
                [
                    "label" => "Renewed",
                    'borderColor' => ['rgb(0,192,239)'],
                    'data' => $renewed_dataset
                ]
            ])
            ->optionsRaw([
                'maintainAspectRatio' => false,
                'spanGaps' => false,
                'elements' => [
                    'line' => [
                        'tension' => 0.000001
                    ],
                ],
                'scales' => [
                    'yAxes' => [
                        [
                            'stacked' => true,
                        ]
                    ]
                ],
                'plugins' => [
                    'filler' => [
                        'propagate' => false
                    ],
                    'samples-filler-analyser' => [
                        'target' => 'chart-analyser'
                    ],
                ],
            ]);
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
        $user->status = 9;
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


}
