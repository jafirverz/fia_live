<?php

namespace App\Http\Controllers;

use App\Event;
use App\Page;
use App\Banner;
use App\TopicalReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Illuminate\Support\Facades\Storage;
class EventController extends Controller
{
    //use DynamicRoute;
    //use GetEmailTemplate;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index(BreadcrumbsManager $breadcrumbs)
    {
        //get page data

		
        $page=Page::where('pages.slug','events')
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }
		//dd($page->id);
        $banner = get_page_banner($page->id);

        $title = __('constant.EVENT');
        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		$events =Event::all();
		$data=array('month'=>'','year'=>'');
        return view('resources/index', compact('title', 'events', 'page', 'banner' ,'data','breadcrumbs'));
    }
	
	public function reports(BreadcrumbsManager $breadcrumbs)
    {
        //get page data

		
        $page=Page::where('pages.slug', __('constant.TOPICAL_REPORT_SLUG'))
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }
        $banner = get_page_banner($page->id);
        $data=array('topic'=>"");
        $title = __('constant.TOPICAL_REPORTS');
        $breadcrumbs = $breadcrumbs->generate('front_report_listing');
		$reports =TopicalReport::all();
        return view('resources/index-report', compact('title', 'reports', 'page', 'banner','breadcrumbs','data'));
    }
	
	public function search_report(BreadcrumbsManager $breadcrumbs, Request $request)
    {

        $page=Page::where('pages.slug', __('constant.TOPICAL_REPORT_SLUG'))
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }
        $banner = get_page_banner($page->id);

        $title = __('constant.TOPICAL_REPORTS');
        $breadcrumbs = $breadcrumbs->generate('front_report_listing');
        //dd($request);
        $topic = $request->topic;
		$data=array('topic'=>$topic);
        if ($topic != "")
        {
		$reports = DB::select('SELECT * FROM topical_reports WHERE topical_id LIKE "%'.$topic.'%"');
		}
        
        return view('resources/index-report', compact('title', 'reports', 'page', 'banner','breadcrumbs','data'));
    }
	
	
    public function search(BreadcrumbsManager $breadcrumbs, Request $request)
    {

        $page=Page::where('pages.slug','events')
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
		//dd($page->id);
        $banner = get_page_banner($page->id);

        $title = __('constant.EVENT');
        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
        //dd($request);
        $year = $request->year;
		$month = $request->month;
		$data=array('month'=>$month,'year'=>$year);
        if ($month != "" && $year == "")
        {
		$events = DB::select('SELECT * FROM events WHERE MONTH(event_date)='.$month);
		}
        else if ($month == "" && $year != "")
        {
		$events = DB::select('SELECT * FROM events WHERE YEAR(event_date)='.$year);
		}
        else
        {
		$events = DB::select('SELECT * FROM events WHERE MONTH(event_date)='.$month.' AND YEAR(event_date)='.$year);		
		}
        //print_r($events);die;

        return view('resources/index', compact('title', 'breadcrumbs', 'events', 'page', 'banner', 'data'));
    }



    public function detail(BreadcrumbsManager $breadcrumbs, $slug)
    {

        $page = pageDetails(__('constant.EVENTS_DETAIL_SLUG'));
        if (!$page) {
           return abort(404);
        }
        $title = __('constant.EVENT_DETAIL');
		$banner = get_page_banner($page->id);
		$slug=str_replace("-"," ",$slug);
		$breadcrumbs = $breadcrumbs->generate('front_event_detail',strtoupper($slug));
		$event = Event::where('event_title', strtoupper($slug))->first();
		if (!$event) {
           return abort(404);
        }

        //dd($news);
        return view('resources/event-details', compact('title', 'breadcrumbs', 'event',  'page' , 'banner'));
    }




}
