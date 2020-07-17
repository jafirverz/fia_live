<?php

namespace App\Http\Controllers;
use App\Podcast;
use App\Page;
use App\Banner;
use App\Filter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Illuminate\Support\Facades\Storage;
class PodcastController extends Controller
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

		
        $page=Page::where('pages.slug','podcast')
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }
		//dd($page->id);
        $banner = get_page_banner($page->id);

        $title = __('constant.PODCAST');
        $breadcrumbs = $breadcrumbs->generate('front_pocast_listing');
		if(isset($_GET['id']) && $_GET['id']!='')
		$podcast =Podcast::where('id',$_GET['id'])->first();
		else
		$podcast =Podcast::first();
		$podcasts =Podcast::where('id','!=', $podcast->id)->orderBy('id','desc')->paginate(setting()->pagination_limit);
		$topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name','ASC')->get();
        return view('podcast/index', compact('title', 'podcasts','podcast','topics', 'page', 'banner' ,'breadcrumbs'));
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
		$podcast = Podcast::orderBy('id')->first();
        $podcasts = Podcast::search($request)->where('id','!=', $podcast->id)->orderBy('id')->paginate(setting()->pagination_limit);
		$topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name','ASC')->get();
        return view('podcast/index', compact('title', 'podcasts','podcast','topics', 'page', 'banner' ,'breadcrumbs'));
    }




}
