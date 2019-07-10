<?php
use App\Regulatory;
use App\Page;
use App\Filter;
use App\Menu;
use App\PermissionAccess;
use App\CountryInformation;
use App\RegulatoryHighlight;
use Illuminate\Support\Arr;

if (!function_exists('getTopics')) {

    /**
     * description
     *
     * @param
     * @return
     */

    function CountryList($value = null)
    {
        $country_list = DB::table('country')->orderBy('country', 'asc')->get();
        return $country_list;
    }

    function salutation()
    {
        $array_list = ['Mrs.', 'Mr.', 'Miss.', 'Ms.', 'Mdm.', 'Dr.'];
        return $array_list;
    }

    function getFilterCountry($id = null)
    {
        if ($id) {
            $country = Filter::find($id);
            if ($country) {
                return $country->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 1)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getFilterCountryImage($id = null)
    {
        if ($id) {
            $country = Filter::find($id);
            if ($country) {
                return $country->country_image;
            }
        }
        return '#';
    }


    function getFilterMonth($id = null)
    {
        if ($id) {
            $month = Filter::find($id);
            if ($month) {
                return $month->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 4)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getFilterYear($id = null)
    {
        if ($id) {
            $year = Filter::find($id);
            if ($year) {
                return $year->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 6)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getFilterTopic($id = null)
    {
        if ($id) {
            $topic = Filter::find($id);
            if ($topic) {
                return $topic->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

	function getTopics($topics)
	{
	$topics = Filter::whereIn('id',$topics)->where('status', 1)->orderBy('tag_name', 'asc')->get();
	  $names=[];
	  foreach($topics as $topic)
	  {
	  $names[]=$topic->tag_name;
	  }
	 // dd($names);
	  if(isset($topics) && $topics->count()>0)
	  return implode(',',$names);
	  else
	  return "";
	}

	function getCountryImages($id)
	{
	$topics = Filter::join('topical_report_countries', 'filters.id', '=', 'topical_report_countries.filter_id')->where('topical_report_countries.topical_report_id',$id)->where('status', 1)->orderBy('tag_name', 'asc')->get();
	$names=[];
	//dd($topics);
	  foreach($topics as $topic)
	  {
	  if($topic->country_image!="")
	  $names[]='<span class="show-tooltip" title="'.$topic->tag_name.'"><img src="'.asset($topic->country_image).'" alt="'.$topic->tag_name.' flag" /></span>';
	  }

	  if(isset($names) && count($names)>0)
	  return join('',$names);
	  else
	  return "";
	}


	function getAllCountry()
	{

	  $country = Filter::where('filters.filter_name',1)->where('status', 1)->orderBy('tag_name', 'asc')->get();

	  if(isset($country) && $country->count()>0)
	  return $country;
	  else
	  return "";
	}
	
	function get_categry_by_country($country_id=null)
	{
	 $category=CountryInformation::where('country_id', $country_id)->first();
	 if($category->information_filter_id!="")
	 {
	 $filter = Filter::where('filters.filter_name',5)->where('id', $category->information_filter_id)->first();
	 if($filter)
	 return $filter->tag_name;
	 else
	 return '#';
	 }
	 else
	 {
	 return "#";
	 }
	 
	}
	

	function getCountryId($country=null)
	{

	  $country = Filter::where('filters.filter_name',1)->where('tag_name', $country)->first();

	  if(isset($country) && $country->count()>0)
	  return $country->id;
	  else
	  return "";
	}

    function getFilterStage($id = null)
    {
        if ($id) {
            $stage = Filter::find($id);
            if ($stage) {
                return $stage->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 3)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

	function replaceStrByValue($key, $value, $contents)
    {
        $newContents = str_replace($key, $value, $contents);
        return $newContents;
    }

    function getFilterCategory()
    {
        return Filter::where('filter_name', 5)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getParentRegulatory($id)
    {
        $regulatory = Regulatory::where('id', $id)->first();
        if ($regulatory) {
            return $regulatory->title;
        }
        return '-';
    }

    function get_modules()
    {
        $modules_array = [
            'DASHBOARD','FILTER',  'MENU', 'BANNER',  'PAGE','EVENT','TOPICAL_REPORT','PAYMENT','COUNTRY_INFORMATION','REGULATORY','CONTACTENQUIRY','GROUPMANAGEMENT','EMAIL_TEMPLATE','ROLES_AND_PERMISSION','SYSTEM_SETTING'

        ];

        return $modules_array;
    }

    function is_permission_allowed($permission_id, $module, $type)
    {
        $permission_access = PermissionAccess::join('admins', 'permission_access.role_id', '=', 'admins.admin_role')
            ->where(['permission_access.role_id' => $permission_id, 'permission_access.module' => $module, $type => 1])
            ->get();
        if (!$permission_access->count()) {
            abort(redirect('admin/access-not-allowed'));
        }
    }


    function get_menu_has_child($parent = 0, $type = 1, $page_id = "")

    {
        $string = [];
        $menus = Menu::where('menus.parent', $parent)
            ->where('menus.menu_type', $type)
            ->select('menus.*')
            ->orderBy('view_order', 'asc')
            ->get();

        if ($menus->count() > 0) {
            $string[] = '<ul>';
            $sel = '';
            foreach ($menus as $menu) {
                $link = create_menu_link($menu);
                if ($menu->page_id == NULL)
                    $target = 'target="_blank"';
                else
                    $target = "";

                if ($page_id == $menu->page_id)
                    $sel = 'class="active"';
                else
                    $sel = '';
                $string[] = '<li ' . $sel . '><a ' . $target . ' href="' . $link . '">' . $menu->title . '</a>';

                if (has_child_menu($menu->id) > 0) {

                    $string[] = get_menu_has_child($menu->id, 1);
                }
                $string[] = '</li>';

            }
            $string[] = '</ul>';
        }

        return join("", $string);
    }

    function pageDetail($slug)
    {
        //check page
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->first();
        return $page;

    }

    function bannersDetail($pageId)
    {
        $banners = Banner::where('page_name', $pageId)
            ->where('status', 1)
            ->get();
        return $banners;

    }


    function get_parent_menu($parent = 0, $type = 1, $page_id = "")

    {
        $string = [];
        $menus = Menu::where('menus.parent', $parent)
            ->where('menus.menu_type', $type)
            ->select('menus.*')
            ->orderBy('view_order', 'asc')
            ->get();

        if ($menus->count() > 0) {
            $string[] = '<ul class="links">';
            foreach ($menus as $menu) {
                $link = create_menu_link($menu);
                if ($menu->page_id == NULL)
                    $target = 'target="_blank"';
                else
                    $target = "";


                if ($page_id == $menu->page_id)
                    $sel = 'class="active"';
                else
                    $sel = '';

                $string[] = '<li ' . $sel . '><a ' . $target . ' href="' . $link . '">' . $menu->title . '</a>';
                $string[] = '</li>';


            }
            $string[] = '</ul>';
        }

        return join("", $string);
    }

    function create_menu_link($item = [])
    {

        if ($item['page_id'] == NULL) {
            return $item->external_link;
        } else {
            $page = Page::where('id', $item['page_id'])->select('pages.slug')->first();
            return url($page['slug']);
        }
    }

    function has_child_menu($parent = 0)
    {
        $menus = Menu::where('parent', $parent)->count();
        if ($menus > 0)
            return $menus;
        else
            return 0;

    }

    function getAllTopics()
    {
        $topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name', 'asc')->get();

        // dd($names);
        if (isset($topics) && $topics->count() > 0)
            return $topics;
        else
            return "";
    }

    function checkCountryExist($country = Null)
    {

        $country = Filter::where('filter_name', 1)->where('status', 1)->where('home_status', 1)->where('tag_name', $country)->count();
        if ($country > 0)
            return 1;
        else
            return 0;
    }

    function getYearList()
    {
        return range(2019, 2025);
    }

    function getMonthList()
    {
        return array(
            "1" => "January", "2" => "February", "3" => "March", "4" => "April",
            "5" => "May", "6" => "June", "7" => "July", "8" => "August",
            "9" => "September", "10" => "October", "11" => "November", "12" => "December",
        );


    }

    function get_filter_name($value = null)
    {
        $array_list = ["1" => 'Country', "2" => 'Topic', "3" => 'Stage', "4" => 'Month', "5" => 'Category', '6' => 'Year'];

        if ($value) {
            return $array_list[$value];
        }
        return $array_list;
    }

    function get_permission_access_value($type, $module, $value, $role_id = null)
    {
        $permission_access = PermissionAccess::where(['role_id' => $role_id, $type => $value, 'module' => $module])->get();
        if ($permission_access->count()) {
            return 'checked';
        }
    }

    function admin_last_login($id)
    {
        $authentication_log = DB::table('authentication_log')->where('authenticatable_id', $id)->orderby('id', 'desc')->first();
        if ($authentication_log) {
            return date('d M, Y H:i A', strtotime($authentication_log->login_at));
        }
        return "-";
    }

    function get_filter_name_by_id($value = null)
    {
        $array_list = get_filter_name();
        return $array_list[$value];
    }

    function ActiveInActinve($value = null)
    {
        $array_list = ["1" => 'Active', "0" => 'De-Active'];;
        if ($value) {
            return $array_list[$value - 1];
        }
        return $array_list;
    }

    function get_payment_mode($value = null)
    {
        $array_list = ["1" => 'Online', "0" => 'Offline'];;
        if ($value) {
            return $array_list[$value - 1];
        }
        return $array_list;
    }

    function get_status($value = null)
    {
        $array_list = ["1" => 'Paid', "0" => 'UnPaid'];;
        if ($value) {
            return $array_list[$value - 1];
        }
        return $array_list;
    }

    function get_page_name($id)
    {
        $page = Page::where("id", $id)->select("title")->first();
        if (isset($page))
            return $page->title;
        else
            return NULL;
    }

    function member($id = null)
    {
        $array_list = ['Arvind', 'Nikunj', 'Jafir', 'Apoorva', 'Glenn', 'Henry'];
        return $array_list;
    }

    function inactiveActive($id = null)
    {
        $array_list = ['Inactive', 'Active'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function guid()
    {
        return uniqid();
    }

    function getCountryInformationCounter($country_id, $information_filter_id)
    {
        return CountryInformation::where('country_id', $country_id)->where('information_filter_id', $information_filter_id)->count();
    }

    function getCountryInformation($country_id, $information_filter_id)
    {
        return CountryInformation::where('country_id', 'like', '%' . $country_id . '%')->where('information_filter_id', $information_filter_id)->get();
    }

    function getCountryInformationBasedOnDetails($country, $category)
    {
        $country_id = getFilterId($country);
        $category_id = getFilterId($category);
        return getCountryInformation($country_id, $category_id);
    }

    function getFilterId($tag_name)
    {
        $result = Filter::where('tag_name', $tag_name)->first();
        if($result)
        {
            return $result->id;
        }
    }

    function getTopicsName($id = null)
    {
        $topics = DB::table('filters')->whereIn('id', $id)->select('tag_name')->get();
        foreach ($topics as $topic) {
            $title[] = $topic->tag_name;
        }
        // print_r($title);
        if (is_array($title) && count($title) > 0)
            return implode(',', $title);
        else
            return __('constant.NONE');
    }

    function getCountryByTopicalReportId($id)
    {
        $countries = DB::table('filters')
            ->join('topical_report_countries', 'filters.id', '=', 'topical_report_countries.filter_id')
            ->where('topical_report_countries.topical_report_id', $id)
            ->select('filters.tag_name')
            ->get();

        foreach ($countries as $country) {
            $title[] = $country->tag_name;
        }
        if (is_array($title) && count($title) > 0)
            return implode(',', $title);
        else
            return __('constant.NONE');
    }

    function getRegulatoriesHighlight()
    {
        return RegulatoryHighlight::first();
    }

    function getRegulatories($slug = null)
    {
        if ($slug) {
            return Regulatory::where('slug', $slug)->first();
        }
        return Regulatory::latestregulatory();
    }

    function getRegulatoryById($id = null)
    {
        if ($id) {
            return Regulatory::where('id', $id)->first();
        }
    }

    function getFilterData($id)
    {
        if ($id) {
            return Filter::where('filter_name', $id)->where('status', 1)->get();
        }
    }

    function memberType($key = null)
    {
        $array_list = ["1" => 'FIA Member', "2" => 'Member', "3" => 'Complimentary'];

        if (!is_null($key)) {
            if (Arr::has($array_list, $key)) {
                return $array_list[$key];
            } else {
                return null;
            }

        }
        return $array_list;
    }
    function subscriptionPeriodType($key = null)
    {
        $array_list = ["1" => 'Month', "2" => 'Year'];

        if (!is_null($key)) {
            if (Arr::has($array_list, $key)) {
                return $array_list[$key];
            } else {
                return null;
            }

        }
        return $array_list;
    }
    function memberShipStatus($key = null)
    {
        $array_list = ["1" => 'Pending email verification', "2" => 'Pending admin approval','3'=>'Rejected','4'=>'Pending for Payment','5'=>'Active','6'=>'Inactive','7'=>'Lapsed','8'=>'Expired','9'=>'Deleted','10'=>'Subscriber Only'];

        if (!is_null($key)) {
            if (Arr::has($array_list, $key)) {
                return $array_list[$key];
            } else {
                return null;
            }

        }
        return $array_list;
    }
}
