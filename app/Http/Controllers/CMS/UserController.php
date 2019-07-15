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
        $users = User::all();
        return view('admin.users.index', compact('title', 'users','subtitle'));
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
            'group_name' => 'required|unique:group_managements,group_name',
            'group_members' => 'required',
            'status' => 'required',
        ]);
        $groupmanagement = new GroupManagement();
        $groupmanagement->group_name = $request->group_name;
        $groupmanagement->group_members = null;
        $groupmanagement->status = $request->status;
        $groupmanagement->save();
        if (count($request->group_members)) {
            foreach ($request->group_members as $member) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $member;
                $groupUserId->group_id = $groupmanagement->id;
                $groupUserId->save();
            }
        }

        return redirect('admin/group-management')->with('success', __('constant.CREATED', ['module' => __('constant.GROUPMANAGEMENT')]));
    }
}
