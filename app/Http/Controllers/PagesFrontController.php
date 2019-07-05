<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Str;
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
            $banner = Banner::where('page_name', $page->id)->first();
        if(!$page)
        {
            return abort(404);
        }

        if($page->slug=='country-information')
        {
            return view('country_information.country-information', compact('banner'));
        }
        elseif($page->slug=='regulatory-updates')
        {
            return view('regulatory.regulatory-updates', compact('banner'));
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

    public function regulatory_details_search()
    {
        $country = isset($_GET['country']) ? $_GET['country'][0] : '';
        $month = isset($_GET['month']) ? $_GET['month'][0] : '';
        $year = isset($_GET['year']) ? $_GET['year'][0] : '';
        $topic = isset($_GET['topic']) ? $_GET['topic'][0] : '';
        $stage = isset($_GET['stage']) ? $_GET['stage'][0] : '';
        $option_type = isset($_GET['option_type']) ? $_GET['option_type'] : '';


        $query = Regulatory::query();
        if($country)
        {
            $query->whereIn('country_id', $country);
        }
        if($month)
        {
            $query->whereMonth('created_at', date('m', strtotime($month)));
        }
        if($year)
        {
            $query->whereYear('created_at', date('Y', strtotime($year)));
        }
        if($topic)
        {
            $query->where('topic_id', 'like', '%'.$topic.'%');
        }
        if($stage)
        {
            $query->where('stage_id', $stage);
        }
        $result = $query->get();

        if($option_type)
        {
            $result = Regulatory::all();
        }
        foreach($result as $value)
        {
        ?>
            <div class="item">
                <div class="box-4">
                    <figure><img src="<?php  echo getFilterCountryImage($value->country_id); ?>" alt="<?php  echo getFilterCountry($value->country_id); ?> flag" /></figure>
                    <div class="content">
                        <h3 class="title"><?php echo $value->title ?></h3>
                        <p class="date"><span class="country"><?php  echo getFilterCountry($value->country_id); ?></span> |
                            <?php echo $value->created_at->format('M d, Y'); ?></p>
                            <?php echo html_entity_decode(Str::limit($value->description, 400)); ?>
                    </div>
                    <a class="detail" href="<?php echo url('regulatory-details', $value->slug); ?>">View detail</a>
                </div>
            </div>
        <?php
        }
    }
}
