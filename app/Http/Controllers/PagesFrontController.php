<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PagesFrontController extends Controller
{
    public function __construct()
    {
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
