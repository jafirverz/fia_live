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
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banner = get_page_banner($page->id);

        $title = __('constant.EVENT');
       // $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		$events =Event::all();
        return view('resources/index', compact('title', 'events', 'page', 'banner'));
    }
	
	public function reports(BreadcrumbsManager $breadcrumbs)
    {
        //get page data

		
        $page=Page::where('pages.slug', __('constant.TOPICAL_REPORT_SLUG'))
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banner = get_page_banner($page->id);

        $title = __('constant.TOPICAL_REPORTS');
       // $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		$reports =TopicalReport::all();
        return view('resources/index-report', compact('title', 'reports', 'page', 'banner'));
    }
	
	
    public function search(BreadcrumbsManager $breadcrumbs, Request $request)
    {

        $page = $this->pageDetail(__('constant.EVENTS_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);

        $title = __('constant.EVENT');
        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
        //dd($request);
        $search_content = $request->search_content;
        if ($search_content != "" && $request->eventtype == "")
            {
			//$events = Event::whereDate('start_date', '>', Carbon::now())->where('title', 'LIKE', '%' . $search_content . '%')->get();

		$events = DB::select("SELECT * FROM events WHERE events.title LIKE '%".$search_content."%' AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0  ORDER BY start_date ASC");
			

			}
        else if ($search_content == "" && $request->eventtype != "")
         {
			if($request->eventtype=='all')
			{$events = DB::select("SELECT * FROM events WHERE (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0  ORDER BY start_date ASC");}
			else
			{
			$events = DB::select("SELECT * FROM events WHERE events.type=".$request->eventtype." AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0   ORDER BY start_date ASC");
			}
		}
        else
        {
//$events = Event::whereDate('start_date', '>', Carbon::now())->where('title', 'LIKE', '%' . $search_content . '%')->where('type', $request->eventtype)->get();
		$events = DB::select("SELECT * FROM events WHERE events.type=".$request->eventtype." AND events.title LIKE '%".$search_content."%' AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0   ORDER BY start_date ASC");
		}
        //print_r($events);die;

        return view('event/events', compact('title', 'breadcrumbs', 'events', 'page', 'banners'));
    }



    public function detail(BreadcrumbsManager $breadcrumbs, $id)
    {

        $page = pageDetails(__('constant.EVENTS_DETAIL_SLUG'));
        if (!$page) {
           return abort(404);
        }
        $title = __('constant.EVENT_DETAIL');
		$banner = get_page_banner($page->id);
        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		$event = Event::where('id', $id)->first();
		

        //dd($news);
        return view('resources/event-details', compact('title', 'breadcrumbs', 'event',  'page' , 'banner'));
    }




}
