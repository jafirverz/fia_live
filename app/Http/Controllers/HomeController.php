<?php

namespace App\Http\Controllers;
use App\Page;
use App\User;
use App\Banner;
use App\Regulatory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\DynamicRoute;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\UserSideMail;
use App\Mail\AdminSideMail;
use Auth;
class HomeController extends Controller
{
    use DynamicRoute;
    use GetEmailTemplate;

	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($slug = 'home')
    {
        
		$page=Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
		if (!$page) {
            return abort(404);
        }	
		$banners = Banner::where('page_name', $page->id)->orderBy('order_by','ASC')->get();	
		$regulatories = Regulatory::join('filters', 'filters.id', '=', 'regulatories.country_id')->get();
		return view('home',compact('page','banners','regulatories'));
    }
	 public function search_regulatory($slug = 'search-results-regulatory')
	 {
		//dd($_GET); 
		 $country=getCountryId($_GET['country']);
		 $regulatories = Regulatory::where('country_id', $country)->limit(setting()->pagination_limit)->get();
		 $total_regulatories = Regulatory::where('country_id', $country)->count();
		 $page=Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
		if (!$page) {
            return abort(404);
        }	
		
		$banner = get_page_banner($page->id);
		//dd($banner->banner_image);
		$breadcrumbs = getBreadcrumb($page);
		return view('search-results-regulatory',compact('page','banner','regulatories','breadcrumbs','total_regulatories'));
	}
	 public function search(Request $request)
    {
       

		$ActiveCountries = getFilterCountry()->pluck('id')->all();
		$slug = __('constant.SEARCH_RESULTS');
		$page=pageDetails($slug);
		$breadcrumbs = getBreadcrumb($page);	
		$banner =get_page_banner($page->id);
		$country_name=getCountryId($request->country);
		//dd($country_name);
		
		$events=$others=$reports=$regulatories=$informations=[];
		//Events
		$event_title = DB::table('events')
                ->where('event_title', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($event_title) && $event_title->count())
		{

		  foreach($event_title as $event)
		  {
		  $item['content']=$event->event_title;
		  $event_title=str_replace(" ","-",$event->event_title);
		  $item['link']=url('event/'.strtolower($event_title));
		  $events[]=$item;
		  }
		}
		
		$event_description = DB::table('events')
                ->where('description', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($event_description) && $event_description->count())
		{
		
		  foreach($event_description as $event)
		  {
		  $item['content']=substr(strip_tags($event->description),0,120);
		  $event_title=str_replace(" ","-",$event->event_title);
		  $item['link']=url('event/'.strtolower($event_title));
		  $events[]=$item;
		  }
		}
		//dd($events);
		
		//Topical Reports
		if($request->country!="Other")
		{
			$report_description = DB::table('topical_reports')
				->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
				->where('topical_reports.description', 'like', '%'.$request->search_content.'%')
				->whereNotIn('topical_report_countries.filter_id', $ActiveCountries)
				->get();
		}
		elseif($request->country!="" && $request->search_content!="")
		{
		$report_description = DB::table('topical_reports')
		 		->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.description', 'like', '%'.$request->search_content.'%')
				->where('topical_report_countries.filter_id', $request->country)
                ->get();
		}
		else
		{
		$report_description = DB::table('topical_reports')
                ->where('topical_reports.description', 'like', '%'.$request->search_content.'%')
                ->get();
		}
		
		
		if(isset($report_description) && $report_description->count())
		{
		
		  foreach($report_description as $report)
		  {

		  $item['content']=substr(strip_tags($report->description),0,120);
		  $item['link']=url('topical-reports');
		  $reports[]=$item;
		  }
		}
		if($request->country=="Other"){
			$report_title = DB::table('topical_reports')
				->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
				->where('topical_reports.title', 'like', '%'.$request->search_content.'%')
				->whereNotIn('topical_report_countries.filter_id', $ActiveCountries)
				->get();
		}
		elseif($request->country!="" && $request->search_content!="")
		{
		$report_title = DB::table('topical_reports')
		 		->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.title', 'like', '%'.$request->search_content.'%')
				->where('topical_report_countries.filter_id', $request->country)
                ->get();
		}
		else
		{
		$report_title = DB::table('topical_reports')
                ->where('topical_reports.title', 'like', '%'.$request->search_content.'%')
                ->get();
		}
		
		
		if(isset($report_title) && $report_title->count())
		{

		  foreach($report_title as $report)
		  {
		  $item['content']=$report->title;
		  $item['link']=url('topical-reports');
		  $reports[]=$item;
		  }
		}
		
		//dd($reports);
		//Pages
		
		$cms_title = DB::table('pages')
                ->where('title', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($cms_title) && $cms_title->count())
		{
		  foreach($cms_title as $cms)
		  {
		  $item['content']=$cms->title;
		  $item['link']=url($cms->slug);
		  $others[]=$item;
		  }
		}
		
		$cms_description = DB::table('pages')
                ->where('contents', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($cms_description) && $cms_description->count())
		{
		  foreach($cms_description as $cms)
		  {
		  $item['content']=substr(strip_tags($cms->contents),0,120);
		  $item['link']=url($cms->slug);
		  $others[]=$item;
		  }
		}
		//Regulatories
		if($request->country=="Other"){
			$regulatories_description = DB::table('regulatories')
				->where('description', 'like', '%'.$request->search_content.'%')
				->whereNotIn('country_id',$ActiveCountries)
				->get();
		}
		elseif($request->country!="" && $request->search_content!="")
		{
		$regulatories_description = DB::table('regulatories')
                ->where('description', 'like', '%'.$request->search_content.'%')
				->where('country_id',$request->country)
                ->get();
		}
		else
		{
		$regulatories_description = DB::table('regulatories')
                ->where('description', 'like', '%'.$request->search_content.'%')
                ->get();
		}
		
		
		if(isset($regulatories_description) && $regulatories_description->count())
		{
		
		  foreach($regulatories_description as $regulatory)
		  {

		  $item['content']=substr(strip_tags($regulatory->description),0,120);
		  $item['link']=url('regulatory-details',$regulatory->slug);
		  $regulatories[]=$item;
		  }
		}
		if($request->country=="Other"){

			$regulatories_title = DB::table('regulatories')
				->where('title', 'like', '%'.$request->search_content.'%')
				->whereNotIn('country_id',$ActiveCountries)
				->get();
		}

		elseif($request->country!="" && $request->search_content!="")
		{
		$regulatories_title = DB::table('regulatories')
                ->where('title', 'like', '%'.$request->search_content.'%')
				->where('country_id',$request->country)
                ->get();
		}
		else
		{
		$regulatories_title = DB::table('regulatories')
                ->where('title', 'like', '%'.$request->search_content.'%')
                ->get();
		}
		
		
		if(isset($regulatories_title) && $regulatories_title->count())
		{

		  foreach($regulatories_title as $regulatory)
		  {
		  $item['content']=$regulatory->title;
		  $item['link']=url('regulatory-details',$regulatory->slug);
		  $regulatories[]=$item;
		  }
		}
		
		//dd($regulatories);
		
		//Country Information
		if($request->country=="Other"){
			$information_title = DB::table('country_information')
				->where('information_title', 'like', '%'.$request->search_content.'%')
				->whereNotIn('country_id',$ActiveCountries)
				->get();
		}
		elseif($request->country!="" && $request->search_content!="")
		{
		$information_title = DB::table('country_information')
                ->where('information_title', 'like', '%'.$request->search_content.'%')
				->where('country_id',$request->country)
                ->get();
		}
		else
		{
		$information_title = DB::table('country_information')
                ->where('information_title', 'like', '%'.$request->search_content.'%')
                ->get();
		}
		
		if(isset($information_title) && $information_title->count())
		{

		  foreach($information_title as $information)
		  {
		  $category=get_categry_by_country($information->country_id);
		  $item['country']=getFilterCountry($information->country_id);
		  $item['content']=$information->information_title;
		  $item['link']=url('country-information-details?country='.getFilterCountry($information->country_id).'&category='.$category);
		  $informations[]=$item;
		  }
		}

		if($request->country=="Other"){
			$information_description = DB::table('country_information')
				->where('information_content', 'like', '%'.$request->search_content.'%')
				->whereNotIn('country_id',$ActiveCountries)
				->get();
		}
		elseif($request->country!="" && $request->search_content!="")
		{
		$information_description = DB::table('country_information')
                ->where('information_content', 'like', '%'.$request->search_content.'%')
				->where('country_id',$request->country)
                ->get();
		}
		else
		{
		$information_description = DB::table('country_information')
                ->where('information_content', 'like', '%'.$request->search_content.'%')
                ->get();
		}		
				
		if(isset($information_description) && $information_description->count())
		{
		
		  foreach($information_description as $info)
		  {
		  $category=get_categry_by_country($info->country_id);
		  $item['country']=getFilterCountry($info->country_id);
		  $item['content']=substr(strip_tags($info->information_content),0,120);
		  $item['link']=url('country-information-details?country='.getFilterCountry($info->country_id).'&category='.$category);
		  $informations[]=$item;
		  }
		}
		
		
        //$country = $request->country;
        //$search_content = $request->search_content;
       
			
        $resources=(array_merge($events,$reports));
       
       return view('search-results',compact('page','banner','resources','others','regulatories','informations','breadcrumbs'));

    }
	
	 public function get_category()
    {
        $country = isset($_GET['country']) ? $_GET['country'] : '';
		$country_id=getCountryId($country);
 		$category=get_categry_by_country($country_id);
		return $category;
        
    }
	
	public function subscribers(Request $request)
	{
		$emailid=$request->emailid;
		$result = User::where('email', $emailid)->count();
		$result1 = User::where('email', $emailid)->where('subscribe_status', 1)->count();
		$emailTemplate_user = $this->emailTemplate(__('constant.SUBSCRIPTION_USER_EMAIL_TEMP_ID'));
		if ($emailTemplate_user) {



            $data_user = [];

            $data_user['subject'] = $emailTemplate_user->subject;

            $data_user['email_sender_name'] = setting()->email_sender_name;

            $data_user['from_email'] = setting()->from_email;

            $data_user['subject'] = $emailTemplate_user->subject;

            /*$key_user = ['{{name}}'];

            $value_user = [$request->name];

            $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);*/

            $data_user['contents'] = $emailTemplate_user->contents;



        }
		 if($result1==1)
		 {
		  echo '<div class="error">'.__('constant.SUBSCRIBE_EXIST').'</div>';
		 //return redirect(route('home'))->with('success', __('constant.EXIST', ['module' => __('constant.SUBSCRIBER')])); 
		 }
		 elseif($result==1)
		 {
		 $item = User::where('email', $emailid)->first();	
		 $User = User::findorfail($item->id);
		 $User->email = $request->emailid;
		 $User->subscribe_status = 1;
		 $User->status = 6;
		 $User->updated_at = Carbon::now()->toDateTimeString();
         $User->save();
		 try {
				$mail_user = Mail::to($emailid)->send(new UserSideMail($data_user));

            } catch (Exception $exception) {
                dd($exception);
                return redirect(url('/home'))->with('error', __('constant.OPPS'));
 		   }
		 echo '<div class="success">'.__('constant.SUBSCRIBE_UPDATE').'</div>';
		 //return redirect(route('home'))->with('success', __('constant.UPDATED', ['module' => __('constant.SUBSCRIBER')]));
		 }
		 else
		 {
		 $User = new User;	 
		 $User->email = $request->emailid;
		 $User->subscribe_status = 1;
		 $User->status = 6;
		 $User->created_at = Carbon::now()->toDateTimeString();
		 $User->save();
		 try {
				$mail_user = Mail::to($emailid)->send(new UserSideMail($data_user));

            } catch (Exception $exception) {
                dd($exception);
                return redirect(url('/home'))->with('error', __('constant.OPPS'));
 		   }
		 //return redirect(route('home'))->with('success', __('constant.CREATED', ['module' => __('constant.SUBSCRIBER')]));
		 echo '<div class="success">'.__('constant.SUBSCRIBE_CREATE').'</div>';
		 }
	}
}
