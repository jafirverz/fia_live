<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

use App\Banner;
use App\Regulatory;


class PagesFrontController extends Controller
{
    public function __construct()
    {
        $this->module_name = 'COUNTRY_INFORMATION';
    }

    public function index($slug)
    {



		 $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        if(!$page)
        {
            return abort(404);
        }

        if($page->slug=='country-information')
        {
            return view('country_information.country-information');
        }
        elseif($page->slug=='regulatory-updates')
        {
            return view('regulatory.regulatory-updates');
        }
      elseif ($page->page_type == 0) {

		      $banner = Banner::where('page_name', $page->id)->first();
                return view("cms", compact("page", "banner"));
            }

    }

    public function country_information_details()
    {
        return view('country_information.country-information-details');
    }

    public function regulatory_details($slug)
    {
        $regulatory = Regulatory::where('slug', $slug)->first();
        $child_regulatory = Regulatory::childregulatory($regulatory->id);
        return view('regulatory.regulatory-update-details', compact('regulatory', 'child_regulatory'));
    }
}
