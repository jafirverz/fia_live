<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory;
use App\Filter;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RegulatoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'REGULATORY';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('constant.REGULATORY');
        $subtitle = 'Index';
		if(request()->input('list')=='archive')
		{
		$regulatories = Regulatory::where('parent_id', null)->where('delete_status', 1)->get();
		}
		else
		{
        $regulatories = Regulatory::where('parent_id', null)->where('delete_status', null)->get();
		}
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.index', compact('title', 'subtitle', 'regulatories', 'countries', 'topics', 'stages'));
    }
	
	



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.REGULATORY');
        $subtitle = 'Create';

        $regulatories = Regulatory::all()->where('parent_id', 0);
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.create', compact('title', 'subtitle', 'regulatories', 'countries', 'topics', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->highlight);
        $request->validate([
            'title'  =>  'required',
            'agency_responsible' =>  'required',
            'topic_id'  =>  'required',
            'country_id'    =>  'required',
        ]);

        $regulatory = new Regulatory();
        $regulatory->title = $request->title;
        $regulatory->slug = Str::slug($request->title . Str::uuid(), '-');
        $regulatory->agency_responsible = $request->agency_responsible;
        $regulatory->date_of_regulation_in_force = $request->date_of_regulation_in_force ?? null;
        $regulatory->parent_id = null;
        $regulatory->topic_id = json_encode($request->topic_id);
        $regulatory->country_id = $request->country_id;
        $regulatory->save();

        return redirect('admin/regulatory')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.REGULATORY')]));
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
        $title = __('constant.REGULATORY');
        $subtitle = 'Edit';

        $regulatories = Regulatory::all()->where('parent_id', 0)->whereNotIn('id', $id);
        $regulatory = Regulatory::findorfail($id);
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.edit', compact('title', 'subtitle', 'regulatories', 'regulatory', 'countries', 'topics', 'stages'));
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
            'title'  =>  'required',
            'agency_responsible' =>  'required',
            'topic_id'  =>  'required',
            'country_id'    =>  'required',
        ]);

        $regulatory = Regulatory::findorfail($id);
        $regulatory->title = $request->title;
        $regulatory->slug = Str::slug($request->title . Str::uuid(), '-');
        $regulatory->agency_responsible = $request->agency_responsible;
        $regulatory->date_of_regulation_in_force = $request->date_of_regulation_in_force ?? null;
        $regulatory->parent_id = null;
        $regulatory->topic_id = json_encode($request->topic_id);
        $regulatory->country_id = $request->country_id;
        $regulatory->updated_at = Carbon::now();
        $regulatory->save();

        return redirect('admin/regulatory')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.REGULATORY')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $regulatory = Regulatory::findorfail($request->id);
		$regulatory->delete_status = 1;
        $regulatory->save();
		
		Regulatory::where('parent_id',$request->id)->update(['delete_status'=>1]);
		

        return redirect('admin/regulatory')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.REGULATORY')]));
    }
	
	public function restore($id)
    {
        $regulatory = Regulatory::findorfail($id);
		$regulatory->delete_status = NULL;
        $regulatory->save();
		
		Regulatory::where('parent_id',$id)->update(['delete_status'=>NULL]);

        return redirect('admin/regulatory')->with('success',  __('constant.RESTORE', ['module'    =>  __('constant.REGULATORY')]));
    }
	
	public function permanent_destroy(Request $request)
    {
        $regulatory = Regulatory::findorfail($request->id);
        $regulatory->delete();

        return redirect('admin/regulatory?list=archive')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.REGULATORY')]));
    }
}
