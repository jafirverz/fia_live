<?php

namespace App\Http\Controllers\CMS;

use App\Filter;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class FilterController extends Controller
{

    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'FILTER';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.FILTER');
        $filters = Filter::orderBy('filter_name','ASC')->orderBy('order_by','ASC')->get();
        return view("admin.filter.index", compact("filters", "title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');
        //get pages detail
        return view("admin.filter.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
		if($request->filter_name==1 && $request->tag_name!='Other')
		{
        $request->validate([
            'filter_name' => 'required|max:255|unique:filters,filter_name,NULL,id,tag_name,'.$request->tag_name,
            'tag_name' => 'required',
			'country_image' => 'required_if:filter_name,==,1'
        ],
    [
        'country_image.required_if' => 'The :attribute field is required.'
    ]); 
		}
		else
		{
			
		$request->validate([
            'filter_name' => 'required|max:255|unique:filters,filter_name,NULL,id,tag_name,'.$request->tag_name,
            'tag_name' => 'required'
        ]);
		}

        $filter = new Filter;
        $filter->filter_name = $request->filter_name;
        $filter->tag_name = $request->tag_name;
		if(isset($request->country_image))
		$filter->country_image = $request->country_image;
		$filter->status = $request->status;
		//$filter->home_status = ($request->home_status?$request->home_status:0);
		$filter->country_information = ($request->country_information?$request->country_information:0);
		$filter->order_by =($request->order_by?$request->order_by:0);
        $filter->created_at = Carbon::now()->toDateTimeString();
        $filter->save();
        return redirect(route('filter.index'))->with('success', __('constant.CREATED', ['module' => __('constant.FILTER')]));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $filter = Filter::findorfail($id);
        return view("admin.filter.edit", compact("title", "filter"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $filter = Filter::findorfail($id);
        $request->validate([
            'filter_name' => 'required|max:255',
            'tag_name' => 'required'
        ]);

//dd($id);
        $filter->filter_name = $request->filter_name;
        $filter->tag_name = $request->tag_name;
		if(isset($request->country_image))
		$filter->country_image = $request->country_image;
		$filter->status = $request->status;
		$filter->home_status = ($request->home_status?$request->home_status:0);
		$filter->country_information = ($request->country_information?$request->country_information:0);
		$filter->order_by =($request->order_by?$request->order_by:0);
        $filter->updated_at = Carbon::now()->toDateTimeString();
        $filter->save();
        return redirect(route('filter.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.FILTER')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $filter = Filter::findorfail($id);

        $status = ObjectDelete($filter);
        if ($status) {
            return redirect(route('filter.index'))->with('success', __('constant.REMOVED', ['module' => __('constant.FILTER')]));
        } else {
            return redirect(route('filter.index'))->with('error', __('constant.CANNOT_DELETE', ['module' => __('constant.FILTER')]));
        }

    }
}
