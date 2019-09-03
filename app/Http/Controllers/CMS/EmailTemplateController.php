<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use Carbon\Carbon;
use Auth;


class EmailTemplateController extends Controller
{
    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'EMAIL_TEMPLATE';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.EMAIL_TEMPLATE');
        $emailTemplates = EmailTemplate::whereNotNull('contents')->get();
        return view("admin.emailTemplate.index", compact("emailTemplates", "title"));


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
        $emailTemplates = EmailTemplate::whereNull('contents')->select('id', 'title')->get();
        if ($emailTemplates->isEmpty()) {
            return redirect(route('email-template.index'))->with('error', __('constant.EMAIL_TEMPLATE_ERROR', ['module' => __('constant.EMAIL_TEMPLATE')]));
        }
        //get pages detail
        return view("admin.emailTemplate.create", compact("title", "emailTemplates"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $request->validate([
            'contents' => 'required',
            'email_template' => 'required',
            'subject' => 'required',
        ]);
        $emailTemplate = EmailTemplate::findorfail($request->email_template);

        $emailTemplate->contents = $request->contents;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->status = $request->status;
        $emailTemplate->created_at = Carbon::now()->toDateTimeString();
        $emailTemplate->save();

        return redirect(route('email-template.index'))->with('success', __('constant.CREATED', ['module' => __('constant.EMAIL_TEMPLATE')]));

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
        $emailTemplate = EmailTemplate::findorfail($id);
        return view("admin.emailTemplate.edit", compact("title", "emailTemplate"));
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
        $emailTemplate = EmailTemplate::findorfail($id);
        $request->validate([
            'contents' => 'required',
            'subject' => 'required',
        ]);
        $emailTemplate->title = $request->title;
        $emailTemplate->contents = $request->contents;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->status = $request->status;
        $emailTemplate->updated_at = Carbon::now();
        $emailTemplate->save();
        return redirect(route('email-template.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.EMAIL_TEMPLATE')]));
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
        $emailTemplate = EmailTemplate::findorfail($id);
        $emailTemplate->delete();
        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.EMAIL_TEMPLATE')]));
    }
}
