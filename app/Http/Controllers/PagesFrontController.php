<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Str;
use App\Banner;
use App\Regulatory;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

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
            $banner = get_page_banner($page->id);
            $breadcrumbs = getBreadcrumb($page);
        if(!$page)
        {

            return abort(404);

        }


        if($page->slug=='country-information')
        {
            return view('country_information.country-information', compact("page", "banner", "breadcrumbs"));
        }

        elseif($page->slug=='regulatory-updates')
        {
            return view('regulatory.regulatory-updates', compact("page", "banner", "breadcrumbs"));
        }
        if($page->slug=='profile')
        {
            $user = User::find(Auth::user()->id);
            return view('auth.profile', compact("page", "banner", "breadcrumbs", 'user'));
        }
      elseif ($page->page_type == 0) {


                return view("cms", compact("page", "banner", "breadcrumbs"));

            }

    }

    public function country_information_details()
    {
        $title_breadcrumb = [
            'slug'  =>  url()->full(),
            'title' =>  $_GET['country'] . ' ' . $_GET['category'],
        ];
        $slug = __('constant.COUNTRY_INFORMATION_DETAILS');
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        $banner = get_page_banner($page->id);
        $breadcrumbs = getBreadcrumb($page, $title_breadcrumb);
        return view('country_information.country-information-details', compact("page", "banner", "breadcrumbs"));
    }

    public function country_information_print()
    {
        return view('country_information.country-information-print');
    }

    public function regulatory_details($slug)
    {
        $regulatory = Regulatory::where('slug', $slug)->first();
        $child_regulatory = Regulatory::childregulatory($regulatory->id);

        $slug_page = __('constant.REGULATORY_DETAILS');
        $page = Page::where('pages.slug', $slug_page)
            ->where('pages.status', 1)
            ->first();

        $banner = get_page_banner($page->id);
        $title_breadcrumb = [
            'slug'  =>  $regulatory->slug,
            'title' =>  $regulatory->title,
        ];
        $breadcrumbs = getBreadcrumb($page, $title_breadcrumb);


        return view('regulatory.regulatory-update-details', compact('regulatory', 'child_regulatory', "page", "banner", "breadcrumbs"));
    }

    public function regulatory_print($slug)
    {

        $regulatory = Regulatory::where('slug', $slug)->first();
        $child_regulatory = null;
        $id = $_GET['id'] ?? '';
        if($id)
        {
            if(strpos($id, ',') !== false)
            {
                $id = explode(',', $id);
                $child_regulatory = Regulatory::whereIn('id', $id)->latest()->get();
            }
            else
            {
                $child_regulatory = Regulatory::where('id', $id)->get();
            }
        }
        return view('regulatory.regulatory-print', compact('regulatory', 'child_regulatory'));
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
            $query->whereIn('regulatories.country_id', $country);
        }
        if($month)
        {
            $query->whereMonth('regulatories.created_at', date('m', strtotime($month)));
        }
        if($year)
        {
            $query->whereYear('regulatories.created_at', date('Y', strtotime($year)));
        }
        if($topic)
        {
            $query->where('regulatories.topic_id', 'like', '%'.$topic.'%');
        }
        if($stage)
        {
            $query->where('regulatories.stage_id', $stage);
        }

        $result = $query->join('filters', 'regulatories.country_id', '=', 'filters.id')->where('filters.filter_name', 1)->orderBy('filters.tag_name', 'asc')->orderBy('regulatories.title', 'asc')->select('regulatories.created_at as regulatories_created_at', 'regulatories.*', 'filters.*')->get();

        if(!$country && !$month && !$year && !$topic && !$stage)
        {
            $result = Regulatory::latestregulatory();
        }
        if($option_type)
        {
            $result = Regulatory::latestregulatory();
        }
        ?>
            <h1 class="title-1 text-center">Search Results</h1>
            <?php
            if($result->count())
            {
            ?>
            <div class="grid-2 eheight clearfix mbox-wrap" data-num=<?php echo setting()->pagination_limit ?? 8 ?>">
        <?php
        foreach($result as $value)
        {
        ?>

                <div class="item mbox">
                    <div class="box-4">
                        <figure><img src="<?php  echo getFilterCountryImage($value->country_id); ?>" alt="<?php  echo getFilterCountry($value->country_id); ?> flag" /></figure>
                        <div class="content">
                            <div class="ecol">
                                <h3 class="title"><?php echo $value->title ?></h3>
                                <p class="date"><span class="country"><?php  echo getFilterCountry($value->country_id); ?></span> |
                                    <?php echo date('M d, Y', strtotime($value->regulatories_created_at)); ?></p>
                                    <p><?php echo html_entity_decode(Str::limit($value->description, 300)); ?></p>
                            </div>
                        </div>
                        <a class="detail" href="<?php echo url('regulatory-details', $value->slug); ?>">View detail</a>
                    </div>
                </div>

        <?php
        }
        ?>
        <!-- no loop this element -->
        <div class="grid-sizer"></div> <!-- no loop this element -->
            </div>
            <div class="more-wrap"><button id="btn-load-2" class="btn-4 load-more"> Load more <i
                    class="fas fa-angle-double-down"></i></button></div>
        <?php
            }
            else {
                ?>
                    <p class="text-center">No result found.</p>
                <?php
            }
    }

    public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'organization' => 'required|alpha_num',
            'password' => 'required',
        ]);

        $user = User::where('student_id', $id)->first();
        if(password_verify($request->password, $user->password))
        {
            $user->salutation = $request->salutation;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->organization = $request->organization;
            $user->job_title = $request->job_title;
            $user->telephone_code = $request->telephone_code;
            $user->telephone_number = $request->telephone_number;
            $user->mobile_code = $request->mobile_code;
            $user->mobile_number = $request->mobile_number;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->address1 = $request->address1;
            $user->address2 = $request->address2;
            $user->save();
            return redirect('profile')->with('success',  'Success! Profile have been updated.');
        }
        return redirect('profile')->with('error',  'Sorry! Password does not match.');
    }
}
