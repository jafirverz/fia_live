<?php

namespace App\Http\Controllers;
use App\Page;
use App\Banner;
use App\Regulatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class HomeController extends Controller
{
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
		$banners = Banner::where('page_name', $page->id)->get();	
		$regulatories = Regulatory::join('filters', 'filters.id', '=', 'regulatories.country_id')->get();
		return view('home',compact('page','banners','regulatories'));
    }
	
	 public function search(Request $request)
    {
       
        //dd($request);
		$page=pageDetails('search-results');
			
		$banner =get_page_banner($page->id);
		
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
		  $item['content']=$event->description;
		  $event_title=str_replace(" ","-",$event->event_title);
		  $item['link']=url('event/'.strtolower($event_title));
		  $events[]=$item;
		  }
		}
		//dd($events);
		
		//Topical Reports
		
		if($request->country!="" && $request->search_content!="")
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
		  $item['content']=$report->description;
		  $item['link']=url('topical-reports');
		  $reports[]=$item;
		  }
		}
		
		if($request->country!="" && $request->search_content!="")
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
		  $item['content']=$cms->contents;
		  $item['link']=url($cms->slug);
		  $others[]=$item;
		  }
		}
		//Regulatories
		
		if($request->country!="" && $request->search_content!="")
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
		  $item['content']=$regulatory->description;
		  $item['link']="#";
		  $regulatories[]=$item;
		  }
		}
		
		if($request->country!="" && $request->search_content!="")
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
		  $item['link']='#';
		  $regulatories[]=$item;
		  }
		}
		
		//dd($regulatories);
		
		//Country Information
		$information_title = DB::table('country_information')
                ->where('information_title', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($information_title) && $information_title->count())
		{

		  foreach($information_title as $information)
		  {
		  $item['content']=$information->information_title;
		  $item['link']='#';
		  $informations[]=$item;
		  }
		}
		
		$information_description = DB::table('country_information')
                ->where('information_content', 'like', '%'.$request->search_content.'%')
                ->get();
		if(isset($information_description) && $information_description->count())
		{
		
		  foreach($information_description as $info)
		  {
		  $item['content']=$info->information_content;
		  $item['link']='#';
		  $informations[]=$item;
		  }
		}
		
		
        $country = $request->country;
        $search_content = $request->search_content;
       
			
        $resources=(array_merge($events,$reports));
       
       return view('search-results',compact('page','banner','resources','others','regulatories','informations'));

    }
}
