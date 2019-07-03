<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Banner;

class PagesFrontController extends Controller
{
    public function __construct()
    {
        $this->module_name = 'COUNTRY_INFORMATION';
    }

    public function index($page)
    {
        $page = Page::where('pages.slug', $page)
            ->where('pages.status', 1)
            ->first();
		$banner = Banner::where('page_name', $page->id)->first();	
		if($page=='country-information')
        {
            return view('country_information.country-information');
        }
		elseif ($page->page_type == 0) {
                return view("cms", compact("page", "banner"));
            }
    }

    public function country_information_details()
    {
        return view('country_information.country-information-details');
    }
}
