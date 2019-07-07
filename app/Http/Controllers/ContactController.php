<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Page;
use App\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\DynamicRoute;
use Illuminate\Support\Facades\Mail;
use Exception;
use Auth;


class ContactController extends Controller
{
    //use DynamicRoute;
    //use GetEmailTemplate;

    public function index(BreadcrumbsManager $breadcrumbs,$slug='contact-us')
    {
        
        /*if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }*/
        $page=Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
		$banner = Banner::where('page_name', $page->id)->first();	
		if (!$page) {
		return abort(404);
		}
        $title = __('constant.CONTACT');
        $breadcrumbs = $breadcrumbs->generate('front_contact');

        return view('contact',compact('page','banner','breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'emailid' => 'required|email|max:255',
            'enquiry_type' => 'required|max:255',
            'message' => 'required',
            /*'g-recaptcha-response' => 'required|captcha',*/
        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->emailid = $request->emailid;
        $contact->enquiry_type = $request->enquiry_type;
        $contact->message =  ($request->message ? $request->message : '');
        $contact->created_at = Carbon::now()->toDateTimeString();
        $contact->save();

        //Jafir code.. comment by Nikunj
      /* if($request->inquiry_type=='General Inquiry')
            $toEmail = 'inquiry@bgst.edu.sg';
        else if($request->inquiry_type=='Admissions/Academics Inquiry')
            $toEmail = 'registration@bgst.edu.sg';
        else if($request->inquiry_type=='Library Inquiry')
            $toEmail = 'lib@bgst.edu.sg';
        else if($request->inquiry_type=='Online Education Inquiry')*/
         $toEmail = 'jafir.verz@gmail.com';

        //dd($_REQUEST);


        $emailTemplate = $this->emailTemplate(__('constant.CONTACT_US_ADMIN_EMAIL_TEMP_ID'));
		$emailTemplate_user = $this->emailTemplate(__('constant.CONTACT_US_USER_EMAIL_TEMP_ID'));
        if ($emailTemplate) {

            $data = [];
            $data['subject'] = $emailTemplate->subject;
            $data['email_sender_name'] = setting()->email_sender_name;
            $data['from_email'] = setting()->from_email;
            $data['subject'] = $emailTemplate->subject;
            $key = ['{{name}}',  '{{email}}', '{{enquiry_type}}', '{{message}}'];
            $value = [$request->name,$request->emailid, $request->enquiry_type, $request->message];
            $newContents = replaceStrByValue($key, $value, $emailTemplate->contents);
            $data['contents'] = $newContents;
            
        }
		
		if ($emailTemplate_user) {

            $data_user = [];
            $data_user['subject'] = $emailTemplate_user->subject;
            $data_user['email_sender_name'] = setting()->email_sender_name;
            $data_user['from_email'] = setting()->from_email;
            $data_user['subject'] = $emailTemplate_user->subject;
            $key_user = ['{{name}}'];
            $value_user = [$request->name];
            $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
            $data_user['contents'] = $newContents_user;
            
        }
		
		
		try {
				$mail = Mail::to($toEmail)->send(new AdminSideMail($data));
				$mail_user = Mail::to($request->emailid)->send(new UserSideMail($data_user));

            } catch (Exception $exception) {
                //dd($exception);
                return redirect(url('/contact-us'))->with('error', __('constant.OPPS'));

            }
        return redirect(url('/thank-you'))->with('success', __('constant.CREATED', ['module' => __('constant.CONTACT')]));

    }

    public function thanks()
    {
        return view('thanks');
    }
}
