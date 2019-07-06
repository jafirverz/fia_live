<?php

namespace App\Http\Controllers;
use App\Page;
use App\Banner;
use App\Regulatory;
use Illuminate\Http\Request;

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
		$banners = Banner::where('page_name', $page->id)->get();	
		$regulatories = Regulatory::join('filters', 'filters.id', '=', 'regulatories.country_id')->get();
		return view('home',compact('page','banners','regulatories'));
    }
}
