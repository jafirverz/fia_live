<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use Carbon\Carbon;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'COUNTRY';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('constant.COUNTRY');
        $subtitle = 'Index';
        $countries = Country::all();

        return view('admin.country.index', compact('title', 'subtitle', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.COUNTRY');
        $subtitle = 'Create';

        return view('admin.country.create', compact('title', 'subtitle'));
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
            'country_name'  =>  'required|unique:countries,country_name',
        ]);

        $country = new Country();
        $country->country_name = $request->country_name;
        if($request->country_flag)
        {
            $country->country_flag = $request->country_flag;
        }
        $country->save();

        return redirect('admin/country')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.COUNTRY')]));
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
        $title = __('constant.COUNTRY');
        $subtitle = 'Edit';
        $country = Country::findorfail($id);

        return view('admin.country.edit', compact('title', 'subtitle', 'country'));
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
            'country_name'  =>  'required|unique:countries,country_name,'.$id.',id',
        ]);

        $country = Country::findorfail($id);
        $country->country_name = $request->country_name;
        if($request->country_flag)
        {
            $country->country_flag = $request->country_flag;
        }
        $country->updated_at = Carbon::now();
        $country->save();

        return redirect('admin/country')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.COUNTRY')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $country = Country::findorfail($request->id);
        $country->delete();

        return redirect('admin/country')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.COUNTRY')]));
    }
}
