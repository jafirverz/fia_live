<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory;
use App\Filter;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RegulatoryListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'REGULATORY_LIST';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($parent_id)
    {
        $title = __('constant.REGULATORY_LIST');
        $subtitle = 'Index';

        $regulatories = Regulatory::where('parent_id', $parent_id)->get();
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.list.index', compact('title', 'subtitle', 'regulatories', 'countries', 'topics', 'stages', 'parent_id'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parent_id)
    {
        $title = __('constant.REGULATORY_LIST');
        $subtitle = 'Create';

        $regulatories = Regulatory::all()->where('parent_id', 0);
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.list.create', compact('title', 'subtitle', 'regulatories', 'countries', 'topics', 'stages', 'parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parent_id)
    {
        //dd($request->highlight);
        $request->validate([
            'title'  =>  'required|unique:regulatories,title',
            'agency_responsible' =>  'required',
            'date_of_regulation_in_force'   =>  'required',
            'topic_id'  =>  'required',
            'stage_id'  =>  'required',
            'country_id'    =>  'required',
        ]);

        $regulatory = new Regulatory();
        $regulatory->title = $request->title;
        $regulatory->slug = Str::slug($request->title, '-');
        $regulatory->agency_responsible = $request->agency_responsible;
        $regulatory->date_of_regulation_in_force = $request->date_of_regulation_in_force;
        $regulatory->description = $request->description;
        $regulatory->parent_id = $parent_id;
        $regulatory->topic_id = json_encode($request->topic_id);
        $regulatory->stage_id = $request->stage_id;
        $regulatory->country_id = $request->country_id;
        $regulatory->save();

        return redirect('admin/regulatory/list/'.$parent_id)->with('success',  __('constant.CREATED', ['module'    =>  __('constant.REGULATORY')]));
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
    public function edit($parent_id, $id)
    {
        $title = __('constant.REGULATORY_LIST');
        $subtitle = 'Edit';

        $regulatories = Regulatory::all()->where('parent_id', 0)->whereNotIn('id', $id);
        $regulatory = Regulatory::findorfail($id);
        $countries = getFilterData(1);
        $topics = getFilterData(2);
        $stages = getFilterData(3);

        return view('admin.regulatory.list.edit', compact('title', 'subtitle', 'regulatories', 'regulatory', 'countries', 'topics', 'stages', 'parent_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $parent_id, $id)
    {
        $request->validate([
            'title'  =>  'required|unique:regulatories,title,'.$id.',id',
            'agency_responsible' =>  'required',
            'date_of_regulation_in_force'   =>  'required',
            'topic_id'  =>  'required',
            'stage_id'  =>  'required',
            'country_id'    =>  'required',
        ]);

        $regulatory = Regulatory::findorfail($id);
        $regulatory->title = $request->title;
        $regulatory->slug = Str::slug($request->title, '-');
        $regulatory->agency_responsible = $request->agency_responsible;
        $regulatory->date_of_regulation_in_force = $request->date_of_regulation_in_force;
        $regulatory->description = $request->description;
        $regulatory->parent_id = $parent_id;
        $regulatory->topic_id = json_encode($request->topic_id);
        $regulatory->stage_id = $request->stage_id;
        $regulatory->country_id = $request->country_id;
        $regulatory->updated_at = Carbon::now();
        $regulatory->save();

        return redirect('admin/regulatory/list/'.$parent_id)->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.REGULATORY')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $parent_id)
    {
        $regulatory = Regulatory::findorfail($request->id);
        $regulatory->delete();

        return redirect('admin/regulatory/list/'.$parent_id)->with('success',  __('constant.DELETED', ['module'    =>  __('constant.REGULATORY')]));
    }
}