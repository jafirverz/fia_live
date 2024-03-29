<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GroupManagement;
use Carbon\Carbon;
use App\GroupUserId;

class GroupManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'GROUPMANAGEMENT';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('constant.GROUPMANAGEMENT');
        $subtitle = 'Index';
        $groups = GroupManagement::all();

        return view('admin.groupmanagement.index', compact('title', 'subtitle', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.GROUPMANAGEMENT');
        $subtitle = 'Create';

        return view('admin.groupmanagement.create', compact('title', 'subtitle'));
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
            'status' => 'required',
        ]);
        $groupmanagement = new GroupManagement();
        $groupmanagement->group_name = $request->group_name;
        $groupmanagement->status = $request->status;
        $groupmanagement->save();
        if (isset($request->group_members) && count($request->group_members)) {
            foreach ($request->group_members as $member) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $member;
                $groupUserId->group_id = $groupmanagement->id;
                $groupUserId->save();
            }
        }

        return redirect('admin/group-management')->with('success', __('constant.CREATED', ['module' => __('constant.GROUPMANAGEMENT')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('constant.GROUPMANAGEMENT');
        $subtitle = 'Edit';
        $group = GroupManagement::findorfail($id);

        return view('admin.groupmanagement.edit', compact('title', 'subtitle', 'group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name' => 'required|unique:group_managements,group_name,' . $id . ',id',
            'status' => 'required',
        ]);

        $groupmanagement = GroupManagement::findorfail($id);
        $groupmanagement->group_name = $request->group_name;
        $groupmanagement->status = $request->status;
        $groupmanagement->save();

        $members = GroupUserId::where('group_id', $id)->delete();
        if (isset($request->group_members) && count($request->group_members)) {
            foreach ($request->group_members as $member) {
                $groupUserId = new GroupUserId();
                $groupUserId->user_id = $member;
                $groupUserId->group_id = $groupmanagement->id;
                $groupUserId->save();
            }
        }

        return redirect('admin/group-management')->with('success', __('constant.UPDATED', ['module' => __('constant.GROUPMANAGEMENT')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $group = GroupManagement::findorfail($request->id);
        $group->delete();
        $members = GroupUserId::where('group_id', $request->id)->delete();
        return redirect('admin/group-management')->with('success', __('constant.DELETED', ['module' => __('constant.GROUPMANAGEMENT')]));
    }
}
