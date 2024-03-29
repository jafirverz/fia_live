<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use App\Banner;
use App\TopicalReport;
use App\ThinkingPiece;
use App\FeatureResource;
use App\Podcast;
use App\Regulatory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\DynamicRoute;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\UserSideMail;
use App\Mail\AdminSideMail;
use Auth;

class HomeController extends Controller
{
    use DynamicRoute;
    use GetEmailTemplate;


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

        $country_id = null;
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }
        $topical_id = $podcast_id = $think_piece_id = [];
        $featureResource = FeatureResource::findorfail(1);
        $banners = Banner::where('page_name', $page->id)->orderBy('order_by', 'ASC')->get();
        $regulatories = Regulatory::join('filters', 'filters.id', '=', 'regulatories.country_id')->get();

        if ($featureResource->featured_1_type == 1)
            $topical_id[] = $featureResource->featured_1;

        if ($featureResource->featured_2_type == 1)
            $topical_id[] = $featureResource->featured_2;

        if ($featureResource->featured_3_type == 1)
            $topical_id[] = $featureResource->featured_3;

        if ($featureResource->featured_1_type == 2)
            $podcast_id[] = $featureResource->featured_1;

        if ($featureResource->featured_2_type == 2)
            $podcast_id[] = $featureResource->featured_2;

        if ($featureResource->featured_3_type == 2)
            $podcast_id[] = $featureResource->featured_3;

        if ($featureResource->featured_1_type == 3)
            $think_piece_id[] = $featureResource->featured_1;

        if ($featureResource->featured_2_type == 3)
            $think_piece_id[] = $featureResource->featured_2;

        if ($featureResource->featured_3_type == 3)
            $think_piece_id[] = $featureResource->featured_3;
        $topicals = TopicalReport::whereIn('id', $topical_id)->orderBy('id', 'DESC')->get();

        $thinkingPieces = ThinkingPiece::whereIn('id', $think_piece_id)->orderBy('id', 'DESC')->get();
        $podcasts = Podcast::whereIn('id', $podcast_id)->orderBy('id', 'DESC')->get();
        //dd($podcasts);
        return view('home', compact('page', 'banners', 'regulatories', 'country_id', 'topicals', 'thinkingPieces', 'podcasts'));
    }

    public function search_regulatory($slug = 'search-results-regulatory')
    {
        //dd($_GET);
        $country = getCountryId($_GET['country']);
        $country_name = explode(" ", $_GET['country']);
        if ($country == 28) {
            $regulatories = Regulatory::where('title', 'like', '%' . $country_name[1] . '%')->orderBy('regulatory_date', 'DESC')->get();
        } elseif ($country == 29) {
            $regulatories = Regulatory::where('title', 'like', '%Taiwan%')->orderBy('regulatory_date', 'DESC')->get();
        } else {
            $regulatories = Regulatory::where('title', 'like', '%' . $country_name[0] . '%')->orderBy('regulatory_date', 'DESC')->get();
        }
        $total_regulatories = Regulatory::where('country_id', $country)->count();
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return abort(404);
        }

        $banner = get_page_banner($page->id);
        //dd($banner->banner_image);
        $breadcrumbs = getBreadcrumb($page);
        return view('search-results-regulatory', compact('page', 'banner', 'regulatories', 'breadcrumbs', 'total_regulatories'));
    }

    public function search(Request $request)
    {


        $ActiveCountries = getFilterCountry()->pluck('id')->all();
        $slug = __('constant.SEARCH_RESULTS');
        $page = pageDetails($slug);
        $breadcrumbs = getBreadcrumb($page);
        $banner = get_page_banner($page->id);
        $country_name = getCountryId($request->country);
        if ($country_name == 'South Korea') {
            $country_name = 'Korea';
        }
        //dd($country_name);

        $events = $others = $reports = $regulatories = $informations = [];
        //Events
        $event_title = DB::table('events')
            ->where('event_title', 'like', '%' . $request->search_content . '%')
            ->get();
        if (isset($event_title) && $event_title->count()) {

            foreach ($event_title as $event) {
                $item['content'] = $event->event_title;
                $event_title = str_replace(" ", "-", $event->event_title);
                $item['link'] = url('event/' . strtolower($event_title));
                $events[] = $item;
            }
        }

        $event_description = DB::table('events')
            ->where('description', 'like', '%' . $request->search_content . '%')
            ->get();
        if (isset($event_description) && $event_description->count()) {

            foreach ($event_description as $event) {
                $item['content'] = substr(strip_tags($event->description), 0, 120);
                $event_title = str_replace(" ", "-", $event->event_title);
                $item['link'] = url('event/' . strtolower($event_title));
                $events[] = $item;
            }
        }
        //dd($events);
        $events = remove_duplicates_array($events);
        //Topical Reports
        if ($request->country != "Other") {
            $report_description = DB::table('topical_reports')
                ->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.description', 'like', '%' . $request->search_content . '%')
                ->whereNotIn('topical_report_countries.filter_id', $ActiveCountries)
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*', 'topical_report_countries.*')
                ->get();
        } elseif ($request->country != "" && $request->search_content != "") {
            $report_description = DB::table('topical_reports')
                ->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.description', 'like', '%' . $request->search_content . '%')
                ->where('topical_report_countries.filter_id', $request->country)
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*', 'topical_report_countries.*')
                ->get();
        } else {
            $report_description = DB::table('topical_reports')
                ->where('topical_reports.description', 'like', '%' . $request->search_content . '%')
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*')
                ->get();
        }


        if (isset($report_description) && $report_description->count()) {

            foreach ($report_description as $report) {
                $item['id'] = $report->id;
                $item['content'] = substr(strip_tags($report->description), 0, 120);
                $item['link'] = url('topical-reports');
                $reports[] = $item;
            }
        }
        if ($request->country == "Other") {
            $report_title = DB::table('topical_reports')
                ->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.title', 'like', '%' . $request->search_content . '%')
                ->whereNotIn('topical_report_countries.filter_id', $ActiveCountries)
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*', 'topical_report_countries.*')
                ->get();
        } elseif ($request->country != "" && $request->search_content != "") {
            $report_title = DB::table('topical_reports')
                ->join('topical_report_countries', 'topical_reports.id', '=', 'topical_report_countries.topical_report_id')
                ->where('topical_reports.title', 'like', '%' . $request->search_content . '%')
                ->where('topical_report_countries.filter_id', $request->country)
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*', 'topical_report_countries.*')
                ->get();
        } else {
            $report_title = DB::table('topical_reports')
                ->where('topical_reports.title', 'like', '%' . $request->search_content . '%')
                ->orderBy('topical_reports.id', 'DESC')
                ->select('topical_reports.id as topical_reports_id', 'topical_reports.*')
                ->get();
        }


        if (isset($report_title) && $report_title->count()) {

            foreach ($report_title as $report) {
                $item['id'] = $report->topical_reports_id;
                $item['content'] = $report->title;
                $item['link'] = url('topical-reports');
                $reports[] = $item;
            }
        }

        //dd($reports);
        //Pages
        $reports = remove_duplicates_array($reports);
        $cms_title = DB::table('pages')
            ->where('title', 'like', '%' . $request->search_content . '%')
            ->whereNotIn('id', [17, 21, 22, 25, 27, 29, 30, 31, 32])
            ->get();
        if (isset($cms_title) && $cms_title->count()) {
            foreach ($cms_title as $cms) {
                $item['content'] = $cms->title;
                $item['link'] = url($cms->slug);
                $others[] = $item;
            }
        }

        $cms_description = DB::table('pages')
            ->where('contents', 'like', '%' . $request->search_content . '%')
            ->whereNotIn('id', [17, 21, 22, 25, 27, 29, 30, 31, 32])
            ->get();
        if (isset($cms_description) && $cms_description->count()) {
            foreach ($cms_description as $cms) {
                $item['content'] = substr(strip_tags($cms->contents), 0, 120);
                $item['link'] = url($cms->slug);
                $others[] = $item;
            }
        }
        $others = remove_duplicates_array($others);
        //Regulatories
        $regulatories = collect([]);
        $allParentRegulatoryIds = Regulatory::where('parent_id', null)->where('delete_status', null)->pluck('id')->all();
        if (count($allParentRegulatoryIds)) {
            if ($request->country == "Other") {
                $allRegulatories = DB::table('regulatories')
                    ->where('description', 'like', '%' . $request->search_content . '%')
                    ->whereNotIn('country_id', $ActiveCountries)
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('delete_status', NULL)
                    ->orderBy('id', 'asc')
                    ->get();
            } elseif ($request->country != "" && $request->search_content != "") {
                $country_name = getFilterCountry($request->country);
                if ($country_name == 'South Korea') {
                    $country_name = 'Korea';
                }
                $allRegulatories = DB::table('regulatories')
                    ->where('description', 'like', '%' . $request->search_content . '%')
                    ->where('title', 'like', '%' . $country_name . '%')
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('delete_status', NULL)
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $allRegulatories = DB::table('regulatories')
                    ->where('description', 'like', '%' . $request->search_content . '%')
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('delete_status', NULL)
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $regulatoryIds = $allRegulatories->pluck('id')->all();

            /* if (isset($regulatories_description) && $regulatories_description->count()) {

            foreach ($regulatories_description as $value) {
                $regulatory = getRegulatoryData($value->parent_id);
                $item['content'] = substr(strip_tags($value->description), 120);
                if ($regulatory) {
                    $link = url('regulatory-details', $regulatory->slug) . '?id=' . $value->id;
                } else {
                    $link = '#';
                }
                $item['id'] = $value->id;
				$item['link'] = $link;
                $item['title'] = $value->title;
				$item['parent_id'] = $value->parent_id;
                $regulatories[] = $item;
            }
        } */
            if ($request->country == "Other") {

                $regulatories_title_query = DB::table('regulatories')
                    ->where('title', 'like', '%' . $request->search_content . '%')
                    ->whereNotIn('country_id', $ActiveCountries)
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('delete_status', NULL);
                if (count($regulatoryIds)) {
                    $regulatories_title_query = $regulatories_title_query->whereNotIn('id', $regulatoryIds);
                }
                $regulatories_title = $regulatories_title_query->orderBy('id', 'asc')->get();
            } elseif ($request->country != "" && $request->search_content != "") {
                $country_name = getFilterCountry($request->country);
                if ($country_name == 'South Korea') {
                    $country_name = 'Korea';
                }
                $regulatories_title_query = DB::table('regulatories')
                    ->where('title', 'like', '%' . $request->search_content . '%')
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('title', 'like', '%' . $country_name . '%')
                    ->where('delete_status', NULL);
                if (count($regulatoryIds)) {
                    $regulatories_title_query = $regulatories_title_query->whereNotIn('id', $regulatoryIds);
                }
                $regulatories_title = $regulatories_title_query->orderBy('id', 'asc')->get();
            } else {
                $regulatories_title_query = DB::table('regulatories')
                    ->where('title', 'like', '%' . $request->search_content . '%')
                    ->whereIn('parent_id', $allParentRegulatoryIds)
                    ->where('delete_status', NULL);
                if (count($regulatoryIds)) {
                    $regulatories_title_query = $regulatories_title_query->whereNotIn('id', $regulatoryIds);
                }
                $regulatories_title = $regulatories_title_query->orderBy('id', 'asc')->get();
            }
            if (!$allRegulatories->count()) {
                $allRegulatories = $regulatories_title;
            } elseif ($regulatories_title->count()) {
                $allRegulatories = $allRegulatories->merge($regulatories_title)->sortBy('id');
            }

            $nonParentRegulatories = $allRegulatories->where('parent_id', '!=', null);
            $nonParentRegulatoryIds = $nonParentRegulatories->unique('parent_id')->pluck('parent_id')->all();
            if (count($nonParentRegulatoryIds)) {
                $parentRegulatories = $allRegulatories->whereNotIn('id', $nonParentRegulatoryIds)->where('parent_id', null);
                if ($parentRegulatories->count()) {
                    $regulatories = $nonParentRegulatories->groupBy('parent_id')->merge($parentRegulatories->groupBy('id'));
                } else {
                    $regulatories = $nonParentRegulatories->groupBy('parent_id');
                }
            } else {
                $regulatories = $nonParentRegulatories->groupBy('parent_id');
            }
            //$regulatories = $regulatories->where('id',678);

            /* if (isset($regulatories_title) && $regulatories_title->count()) {

            foreach ($regulatories_title as $value) {
                $regulatory = getRegulatoryData($value->parent_id);
                $item['content'] = $value->title;
                if ($regulatory) {
                    $link = url('regulatory-details', $regulatory->slug) . '?id=' . $value->id;
                } else {
                    $link = '#';
                }
                $item['id'] = $value->id;
				$item['link'] = $link;
                $item['title'] = $value->title;
				$item['parent_id'] = $value->parent_id;
                $regulatories[] = $item;
            }
        } */

            //$regulatories=remove_duplicates_array($regulatories);

        }
        //Country Information
        if ($request->country == "Other") {
            $information_title = DB::table('country_information')
                ->where('information_title', 'like', '%' . $request->search_content . '%')
                ->whereNotIn('country_id', $ActiveCountries)
                ->get();
        } elseif ($request->country != "" && $request->search_content != "") {
            $information_title = DB::table('country_information')
                ->where('information_title', 'like', '%' . $request->search_content . '%')
                ->where('country_id', $request->country)
                ->get();
        } else {
            $information_title = DB::table('country_information')
                ->where('information_title', 'like', '%' . $request->search_content . '%')
                ->get();
        }

        if (isset($information_title) && $information_title->count()) {

            foreach ($information_title as $information) {
                $category = getFilterCountry($information->information_filter_id);
                $item['id'] = $information->id;
                $item['country'] = getFilterCountry($information->country_id);
                $item['content'] = $information->information_title;
                $item['link'] = url('country-information-details?country=' . getFilterCountry($information->country_id) . '&category=' . $category);
                $informations[] = $item;
            }
        }

        if ($request->country == "Other") {
            $information_description = DB::table('country_information')
                ->where('information_content', 'like', '%' . $request->search_content . '%')
                ->whereNotIn('country_id', $ActiveCountries)
                ->get();
        } elseif ($request->country != "" && $request->search_content != "") {
            $information_description = DB::table('country_information')
                ->where('information_content', 'like', '%' . $request->search_content . '%')
                ->where('country_id', $request->country)
                ->get();
        } else {
            $information_description = DB::table('country_information')
                ->where('information_content', 'like', '%' . $request->search_content . '%')
                ->get();
        }

        if (isset($information_description) && $information_description->count()) {

            foreach ($information_description as $info) {
                $item['id'] = $info->id;
                $category = getFilterCountry($info->information_filter_id);
                $item['country'] = getFilterCountry($info->country_id);
                $item['content'] = substr(strip_tags($info->information_content), 0, 120);
                $item['link'] = url('country-information-details?country=' . getFilterCountry($info->country_id) . '&category=' . $category);
                $informations[] = $item;
            }
        }

        $informations = remove_duplicates_array($informations);
        //$country = $request->country;
        //$search_content = $request->search_content;

        $resources = (array_merge($events, $reports));

        return view('search-results', compact('page', 'banner', 'resources', 'others', 'regulatories', 'informations', 'breadcrumbs'));
    }

    public function get_category()
    {
        $country = isset($_GET['country']) ? $_GET['country'] : '';
        $country_id = getCountryId($country);
        $category = get_categry_by_country($country_id);
        return $category;
    }

    public function subscribers(Request $request)
    {
        $emailid = $request->emailid;
        $result = User::where('email', $emailid)->count();
        $result1 = User::where('email', $emailid)->where('subscribe_status', 1)->count();
        $emailTemplate_user = $this->emailTemplate(__('constant.SUBSCRIPTION_USER_EMAIL_TEMP_ID'));
        if ($emailTemplate_user) {


            $data_user = [];

            $data_user['subject'] = $emailTemplate_user->subject;

            $data_user['email_sender_name'] = setting()->email_sender_name;

            $data_user['from_email'] = setting()->from_email;

            $data_user['subject'] = $emailTemplate_user->subject;
            /*$key_user = ['{{name}}'];
            $value_user = [$request->name];
            $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);*/

            $data_user['contents'] = $emailTemplate_user->contents;
        }
        if ($result1 == 1) {
            echo '<div class="error">' . __('constant.SUBSCRIBE_EXIST') . '</div>';
            //return redirect(route('home'))->with('success', __('constant.EXIST', ['module' => __('constant.SUBSCRIBER')]));
        } elseif ($result == 1) {
            $item = User::where('email', $emailid)->first();
            $User = User::findorfail($item->id);
            $User->email = $request->emailid;
            $User->subscribe_status = 1;
            $User->status = 6;
            $User->updated_at = Carbon::now()->toDateTimeString();
            $User->save();
            try {
                $mail_user = Mail::to($emailid)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                dd($exception);
                return redirect(url('/home'))->with('error', __('constant.OPPS'));
            }
            echo '<div class="success">' . __('constant.SUBSCRIBE_UPDATE') . '</div>';
            //return redirect(route('home'))->with('success', __('constant.UPDATED', ['module' => __('constant.SUBSCRIBER')]));
        } else {
            $User = new User;
            $User->email = $request->emailid;
            $User->subscribe_status = 1;
            $User->status = 6;
            $User->created_at = Carbon::now()->toDateTimeString();
            $User->save();
            try {
                $mail_user = Mail::to($emailid)->send(new UserSideMail($data_user));
            } catch (Exception $exception) {
                dd($exception);
                return redirect(url('/home'))->with('error', __('constant.OPPS'));
            }
            //return redirect(route('home'))->with('success', __('constant.CREATED', ['module' => __('constant.SUBSCRIBER')]));
            echo '<div class="success">' . __('constant.SUBSCRIBE_CREATE') . '</div>';
        }
    }

    public function unsubscribe($id)
    {
        $emailid = base64_decode($id);
        $result = User::where('email', $emailid)->count();
        $user = User::where('email', $emailid)->first();
        $user->subscribe_status = 0;
        $user->updated_at = Carbon::now()->toDateTimeString();
        $user->save();

        return redirect(url('unsubscribe'));
    }

    public function getUnsubscribe()
    {
        $page = Page::where('pages.slug', 'unsubscribe')
            ->where('pages.status', 1)
            ->firstOrFail();
        $banner = get_page_banner($page->id);
        $breadcrumbs = getBreadcrumb($page);
        if (!$page) {
            return abort(404);
        } else if (isset($_GET['id'])) {
            $id = $_GET['id'];
            return view('unsubscribe', compact("page", "banner", "breadcrumbs", "id"));
        } else {
            return view('unsubscribe-thank-you', compact("page", "banner", "breadcrumbs"));
        }
        return abort(404);
    }
}
