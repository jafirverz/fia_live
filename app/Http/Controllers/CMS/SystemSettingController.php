<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;

class SystemSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'SYSTEM_SETTING';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.SYSTEM_SETTING');
        $systemSetting = SystemSetting::orderBy('id', 'desc')->first();
        if (!$systemSetting) {
            return view("admin.systemSetting.create", compact("systemSetting","title"));
        }
        return view("admin.systemSetting.edit", compact("systemSetting","title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
	    $systemSetting = SystemSetting::all()->count();
        $title = __('constant.CREATE');
		if($systemSetting==0)
        return view('admin.systemSetting.create', compact('title'));
		else
		return redirect('admin/system-setting')->with('error', __('constant.EDITABLE', ['module' => __('constant.SYSTEM_SETTING')]));


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
        $fields = $request->all();
        $validatorFields = [
            'title' => 'required|max:191',
            'logo' => 'required|image|nullable|max:1999',
            'footer' => 'required',
            'email_sender_name' => 'required',
            'from_email' => 'required | email',
            'to_email' => 'required | email',
            'contact_phone' => 'required ',
            'contact_email' => 'required | email ',
            'contact_address' => 'required',
			'pagination_limit' => 'required',

        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $systemSetting = new SystemSetting;
        $systemSetting->title = $request->title;
        $systemSetting->email_sender_name = ucfirst($request->email_sender_name);
        $systemSetting->from_email = $request->from_email;
        $systemSetting->to_email = $request->to_email;
        $systemSetting->contact_phone = $request->contact_phone;
        $systemSetting->contact_email = $request->contact_email;
        $systemSetting->contact_address = $request->contact_address;
        $systemSetting->footer = $request->footer;
		$systemSetting->pagination_limit = $request->pagination_limit;

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/systemSettings')) {
            mkdir('uploads/systemSettings');
        }
        $destinationPath = 'uploads/systemSettings'; // upload path
        $banner_image = '';
        $bannerPath = null;
        if ($request->hasFile('logo')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('logo')->move($destinationPath, $banner_image);
            $bannerPath = $destinationPath . "/" . $banner_image;;
        }

        $systemSetting->logo = $bannerPath;
        $systemSetting->save();

        return redirect('admin/system-setting')->with('success', __('constant.CREATED', ['module' => __('constant.SYSTEM_SETTING')]));
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
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $systemSetting = SystemSetting::findorfail($id);
        return view('admin.systemSetting.edit', compact('title', 'systemSetting'));
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
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');

        $fields = $request->all();
        $request['slug'] = str_slug($request->slug, '-');
        $validatorFields = [
            'title' => 'required|max:191',
            'logo' => 'image|nullable|max:1999',
            'email_template_logo' => 'image|nullable|max:1999',
            'footer' => 'required',
            'email_sender_name' => 'required',
            'from_email' => 'required | email',
            'to_email' => 'required | email',
			'membership_emailid' => 'required | email',
			'general_emailid' => 'required | email',
			'regulatory_emailid' => 'required | email',
            'contact_phone' => 'required ',
            'contact_email' => 'required | email ',
			'feedback_emailid' => 'required | email ',
			'pagination_limit' => 'required',
            'linkedin_link' => 'required',
            'twitter_link'  =>  'required',
			'footer_copyright' => 'required',

        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $systemSetting = SystemSetting::findorfail($id);
        $systemSetting->title = $request->title;
        $systemSetting->email_sender_name = ucfirst($request->email_sender_name);
        $systemSetting->from_email = $request->from_email;
        $systemSetting->to_email = $request->to_email;
		$systemSetting->membership_emailid = $request->membership_emailid;
		$systemSetting->general_emailid = $request->general_emailid;
		$systemSetting->regulatory_emailid = $request->regulatory_emailid;
        $systemSetting->contact_phone = $request->contact_phone;
        $systemSetting->contact_email = $request->contact_email;
		 $systemSetting->feedback_emailid = $request->feedback_emailid;
        //$systemSetting->contact_fax = $request->contact_fax;
        //$systemSetting->contact_address = $request->contact_address;
        //$systemSetting->company_map = $request->company_map;
        $systemSetting->footer = $request->footer;
		$systemSetting->footer_copyright = $request->footer_copyright;
		$systemSetting->pagination_limit = $request->pagination_limit;
        $systemSetting->linkedin_link = $request->linkedin_link;
        $systemSetting->twitter_link = $request->twitter_link;

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/systemSettings')) {
            mkdir('uploads/systemSettings');
        }
        $destinationPath = 'uploads/systemSettings'; // upload path
        $banner_image = '';
        $bannerPath = null;
        if ($request->hasFile('logo')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('logo')->move($destinationPath, $banner_image);
        }


        if ($request->hasFile('logo')) {
            if ($systemSetting->logo) {
                File::delete($systemSetting->logo);
            }
            $bannerPath = $destinationPath . '/' . $banner_image;
            $systemSetting->logo = $bannerPath;
        }

        if ($request->hasFile('email_template_logo')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('email_template_logo')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('email_template_logo')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('email_template_logo')->move($destinationPath, $banner_image);
        }


        if ($request->hasFile('email_template_logo')) {
            if ($systemSetting->email_template_logo) {
                File::delete($systemSetting->email_template_logo);
            }
            $bannerPath = $destinationPath . '/' . $banner_image;
            $systemSetting->email_template_logo = $bannerPath;
        }
        $systemSetting->save();

        return redirect('admin/system-setting')->with('success', __('constant.UPDATED', ['module' => __('constant.SYSTEM_SETTING')]));
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
        $systemSetting = SystemSetting::findorfail($id);
        $systemSetting->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.SYSTEM_SETTING')]));
    }
}
