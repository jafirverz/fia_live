<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'COUNTRY_INFORMATION';
    }

    public function index($page)
    {
        if($page=='country-information')
        {
            return view('country_information.country-information');
        }
    }

    public function country_information_details()
    {
        return view('country_information.country-information-details');
    }
}
