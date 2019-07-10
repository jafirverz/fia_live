<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;

class MasterSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'MASTER_SETTING';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.MASTER_SETTING');
        $masterSetting = MasterSetting::orderBy('id', 'desc')->first();
        if (!$masterSetting) {
            return view("admin.masterSetting.create", compact("masterSetting","title"));
        }
        return view("admin.masterSetting.edit", compact("masterSetting","title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
	    $masterSetting = MasterSetting::all()->count();
        $title = __('constant.CREATE');
		if($masterSetting==0)
        return view('admin.masterSetting.create', compact('title'));
		else
		return redirect('admin/master-setting')->with('error', __('constant.EDITABLE', ['module' => __('constant.MASTER_SETTING')]));

		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $fields = $request->all();
        $validatorFields = [
            'subscription_value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'subscription_validity' => 'required|numeric|min:1',
            'subscription_validity_type' => 'required',
            'gst_percentage' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'gst_no' => 'required',
            'tax_invoice_text' => 'required',
            'invoice_constant' => 'required ',
            'currency' => 'required ',
            'invoice_series_no' => 'required | digits_between:1,5 ',
            'invoice_footer' => 'required',
			'invoice_footer_address' => 'required',

        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $masterSetting = new MasterSetting;
        $masterSetting->subscription_value = $request->subscription_value;
        $masterSetting->subscription_validity = $request->subscription_validity;
        $masterSetting->subscription_validity_type = $request->subscription_validity_type;
        $masterSetting->gst_percentage = $request->gst_percentage;
        $masterSetting->gst_no = $request->gst_no;
        $masterSetting->tax_invoice_text = $request->tax_invoice_text;
        $masterSetting->invoice_constant = $request->invoice_constant;
        $masterSetting->currency = $request->currency;
        $masterSetting->invoice_series_no = $request->invoice_series_no;
		$masterSetting->invoice_footer = $request->invoice_footer;
		$masterSetting->invoice_footer_address = $request->invoice_footer_address;
        $masterSetting->save();

        return redirect('admin/master-setting')->with('success', __('constant.CREATED', ['module' => __('constant.MASTER_SETTING')]));
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
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $masterSetting = MasterSetting::findorfail($id);
        return view('admin.masterSetting.edit', compact('title', 'masterSetting'));
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
      //  is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');

        $fields = $request->all();
        $validatorFields = [
            'subscription_value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'subscription_validity' => 'required|numeric|min:1',
            'subscription_validity_type' => 'required',
            'gst_percentage' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'gst_no' => 'required',
            'tax_invoice_text' => 'required',
            'invoice_constant' => 'required ',
            'currency' => 'required ',
            'invoice_series_no' => 'required | digits_between:1,5 ',
            'invoice_footer' => 'required',
            'invoice_footer_address' => 'required',

        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $masterSetting = new MasterSetting;
        $masterSetting->subscription_value = $request->subscription_value;
        $masterSetting->subscription_validity = $request->subscription_validity;
        $masterSetting->subscription_validity_type = $request->subscription_validity_type;
        $masterSetting->gst_percentage = $request->gst_percentage;
        $masterSetting->gst_no = $request->gst_no;
        $masterSetting->tax_invoice_text = $request->tax_invoice_text;
        $masterSetting->invoice_constant = $request->invoice_constant;
        $masterSetting->currency = $request->currency;
        $masterSetting->invoice_series_no = $request->invoice_series_no;
        $masterSetting->invoice_footer = $request->invoice_footer;
        $masterSetting->invoice_footer_address = $request->invoice_footer_address;
        $masterSetting->save();

        return redirect('admin/master-setting')->with('success', __('constant.UPDATED', ['module' => __('constant.MASTER_SETTING')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //  is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $masterSetting = MasterSetting::findorfail($id);
        $masterSetting->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.MASTER_SETTING')]));
    }
}
