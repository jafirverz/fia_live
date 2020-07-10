<?php

namespace App\Http\Controllers;
use App\ThinkingPiece;
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
class ThinkingPieceController extends Controller
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

        $title = __('constant.THINKING_PIECE');
        $breadcrumbs = $breadcrumbs->generate('front_thinking_piece_listing');
		$thinkingPieces =ThinkingPiece::orderBy('id')->paginate(setting()->pagination_limit);
		$data=array('month'=>'','year'=>'');
        return view('thinking_piece/index', compact('title', 'thinkingPieces', 'page', 'data','banner' ,'breadcrumbs'));
    }
	
	
    public function search(BreadcrumbsManager $breadcrumbs, Request $request)
    {

        $page=Page::where('pages.slug','thinking_piece')
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
		//dd($page->id);
        $banner = get_page_banner($page->id);
        $breadcrumbs = $breadcrumbs->generate('front_thinking_piece_listing');
        $title = __('constant.THINKING_PIECE');
		$year = $request->year;
		$month = $request->month;
		$data=array('month'=>$month,'year'=>$year);
        if ($month != "" && $year == "")
        {
		$thinkingPieces = DB::select('SELECT * FROM thinking_pieces WHERE MONTH(thinking_piece_date)='.$month);
		}
        else if ($month == "" && $year != "")
        {
		$thinkingPieces = DB::select('SELECT * FROM thinking_pieces WHERE YEAR(thinking_piece_date)='.$year);
		}
        else if ($month != "" && $year != "")
        {
		$thinkingPieces = DB::select('SELECT * FROM thinking_pieces WHERE MONTH(thinking_piece_date)='.$month.' AND YEAR(thinking_piece_date)='.$year);		
		}
		else
		{
		$thinkingPieces =ThinkingPiece::orderBy('id')->paginate(setting()->pagination_limit);	
		}
		$data=array('month'=>'','year'=>'');
        return view('thinking_piece/index', compact('title', 'thinkingPieces', 'page', 'banner' ,'breadcrumbs','data'));
    }



    public function detail(BreadcrumbsManager $breadcrumbs, $slug)
    {

        $page = pageDetails('thinking-piece');
        if (!$page) {
           return abort(404);
        }
		if (!Auth::check())
		{
		return redirect()->route('home');	
		}
        $title = __('constant.THINKING_PIECE_DETAIL');
		$banner = get_page_banner($page->id);
		$url_name=str_replace("-"," ",$slug);
		$breadcrumbs = $breadcrumbs->generate('front_thinking_piece_detail',strtoupper($slug));
		$thinkingPiece = ThinkingPiece::where('thinking_piece_title', strtoupper($url_name))->orWhere('thinking_piece_title',$slug)->first();
		if (!$thinkingPiece) {
           return abort(404);
        }

        //dd($news);
        return view('thinking_piece/thinking_piece-details', compact('title', 'breadcrumbs', 'thinkingPiece',  'page' , 'banner'));
    }




}
