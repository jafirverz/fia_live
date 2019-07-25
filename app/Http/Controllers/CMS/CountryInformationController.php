<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CountryInformation;
use App\Filter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CountryInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'COUNTRY_INFORMATION';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('constant.COUNTRY_INFORMATION');
        $subtitle = 'Index';
        $countries = Filter::where('filter_name', 1)->where('status', 1)->get();
        $categories = Filter::where('filter_name', 5)->where('status', 1)->get();

        return view('admin.country_information.index', compact('title', 'subtitle', 'countries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.COUNTRY_INFORMATION');
        $subtitle = 'Create';
        $countries = Filter::where('filter_name', 1)->where('status', 1)->get();
        $categories = Filter::where('filter_name', 5)->where('status', 1)->get();

        return view('admin.country_information.create', compact('title', 'subtitle', 'countries', 'categories'));
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
            'country_id'  =>  'required',
            'information_filter_id' =>  'required',
            'information_title' =>  'required',
            'information_content'   =>  'required',
        ]);

        $country_information = new CountryInformation();
        $country_information->country_id = $request->country_id;
        $country_information->information_filter_id = $request->information_filter_id;
        $country_information->information_title = $request->information_title;
        $country_information->information_title_slug = Str::slug($request->information_title . Str::uuid(), '-');
        $country_information->information_content = $request->information_content;
        $country_information->save();

        return redirect('admin/country-information')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.COUNTRY_INFORMATION')]));
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
        $title = __('constant.COUNTRY_INFORMATION');
        $subtitle = 'Edit';
        $country_information = CountryInformation::findorfail($id);
        $countries = Filter::where('filter_name', 1)->where('status', 1)->get();
        $categories = Filter::where('filter_name', 5)->where('status', 1)->get();

        return view('admin.country_information.edit', compact('title', 'subtitle', 'country_information', 'countries', 'categories'));
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
            'country_id'  =>  'required',
            'information_filter_id' =>  'required',
            'information_title' =>  'required',
            'information_content'   =>  'required',
        ]);

        $country_information = CountryInformation::findorfail($id);
        $country_information->country_id = $request->country_id;
        $country_information->information_filter_id = $request->information_filter_id;
        $country_information->information_title = $request->information_title;
        $country_information->information_title_slug = Str::slug($request->information_title . Str::uuid(), '-');
        $country_information->information_content = $request->information_content;
        $country_information->updated_at = Carbon::now();
        $country_information->save();

        return redirect('admin/country-information')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.COUNTRY_INFORMATION')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $country_information = CountryInformation::findorfail($request->id);
        $country_information->delete();

        return redirect('admin/country-information')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.COUNTRY_INFORMATION')]));
    }

    public function information_list($country_id, $information_filter_id)
    {
        $title = __('constant.COUNTRY_INFORMATION');
        $subtitle = 'List';
        $country_information = CountryInformation::where('country_id', 'like', '%'.$country_id.'%')->where('information_filter_id', $information_filter_id)->get();
        return view('admin.country_information.list', compact('title', 'subtitle', 'country_information', 'country_id', 'information_filter_id'));
    }
}
