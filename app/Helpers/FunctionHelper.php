<?php
use App\Regulatory;
use App\Page;
use App\Filter;
use App\PermissionAccess;
use App\CountryInformation;
if (!function_exists('getTopics')) {

    /**
     * description
     *
     * @param
     * @return
     */

    function getFilterCountry($id = null)
    {
        if($id)
        {
            $country = Filter::find($id);
            if($country)
            {
                return $country->tag_name;
            }
            return '-';
        }
        return Filter::where('filter_name', 1)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getFilterCategory()
    {
        return Filter::where('filter_name', 5)->where('status', 1)->orderBy('tag_name', 'asc')->get();
    }

    function getParentRegulatory($id)
    {
        $regulatory = Regulatory::where('id', $id)->first();
        if($regulatory)
        {
            return $regulatory->title;
        }
        return '-';
    }

	function get_modules()
    {
        $modules_array = [
            'DASHBOARD',  'MENU', 'BANNER',  'PAGE','ROLES_AND_PERMISSION','TOPIC','REGULATORY','EMAIL_TEMPLATE',
        ];

        return $modules_array;
    }

	 function is_permission_allowed($permission_id, $module, $type)
    {
        $permission_access = PermissionAccess::join('admins', 'permission_accesses.role_id', '=', 'admins.admin_role')
            ->where(['permission_accesses.role_id' => $permission_id, 'permission_accesses.module' => $module, $type => 1])
            ->get();
        if (!$permission_access->count()) {
            abort(redirect('admin/access-not-allowed'));
        }
    }

	function get_filter_name($value = null)
    {
        $array_list = ["1" => 'Country', "2" => 'Topic', "3" => 'Stage', "4" => 'Month', "5" => 'Category'];

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
		$array_list=get_filter_name();
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
		$page = Page::where("id",$id)->select("title")->first();
		if(isset($page))
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
        if($id)
        {
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
        return CountryInformation::where('country_id', 'like', '%'.$country_id.'%')->where('information_filter_id', $information_filter_id)->count();
    }

    function getCountryInformation($country_id, $information_filter_id)
    {
        return CountryInformation::where('country_id', 'like', '%'.$country_id.'%')->where('information_filter_id', $information_filter_id)->get();
    }

    function getCountryInformationBasedOnDetails($country, $category)
    {
        $country_id = getFilterId($country);
        $category_id = getFilterId($category);
        return getCountryInformation($country_id, $category_id);
    }

    function getFilterId($tag_name)
    {
        return Filter::where('tag_name', $tag_name)->first()->id;
    }
}
