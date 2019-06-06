<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GroupManagement;
use Carbon\Carbon;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_name'  =>  'required|unique:group_managements,group_name',
            'group_members'  =>  'required',
            'status'  =>  'required',
        ]);

        $groupmanagement = new GroupManagement();
        $groupmanagement->group_name = $request->group_name;
        $groupmanagement->group_members = json_encode($request->group_members);
        $groupmanagement->status = $request->status;
        $groupmanagement->save();

        return redirect('admin/group-management')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.GROUPMANAGEMENT')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name'  =>  'required|unique:group_managements,group_name,'.$id.',id',
            'group_members'  =>  'required',
            'status'  =>  'required',
        ]);

        $groupmanagement = GroupManagement::findorfail($id);
        $groupmanagement->group_name = $request->group_name;
        $groupmanagement->group_members = json_encode($request->group_members);
        $groupmanagement->status = $request->status;
        $groupmanagement->updated_at = Carbon::now();
        $groupmanagement->save();

        return redirect('admin/group-management')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.GROUPMANAGEMENT')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $group = GroupManagement::findorfail($request->id);
        $group->delete();

        return redirect('admin/group-management')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.GROUPMANAGEMENT')]));
    }
}
