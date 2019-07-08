<?php

namespace App\Traits;

use App\Page;
use App\Banner;

trait DynamicRoute
{
    protected function pageDetail($slug)
    {
        //check page
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->first();
        return $page;

    }

    protected function bannersDetail($pageId)
    {
        $banners = Banner::where('page_id', $pageId)
            ->where('status', 1)
            ->get();
        return $banners;

    }
}