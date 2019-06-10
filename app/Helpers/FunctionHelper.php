<?php
use App\Topic;
use App\Country;
use App\Regulatory;

if (!function_exists('getTopics')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getTopics($id)
    {
        $id = json_decode($id);
        $topics = Topic::whereIn('id', $id)->get();
        if($topics->count())
        {
            return $topics->pluck('topic_name');
        }
    }

    function getCountry($id)
    {
        $country = Country::find($id);
        if($country)
        {
            return $country->country_name;
        }
        return '-';
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

	
	function get_filter_name($value = null)
    {
        $array_list = ["1" => 'Country', "2" => 'Topic', "3" => 'Stage', "4" => 'Month'];

        if ($value) {
            return $array_list[$value];
        }
        return $array_list;
    }
	
	function get_filter_name_by_id($value = null)
	{
		$array_list=get_filter_name();
		return $array_list[$value];
	}
	
	function ActiveInActinve($value = null)
    {
        $array_list = ["1" => 'Active', "0" => 'In-Active'];;
        if ($value) {
            return $array_list[$value - 1];
        }
        return $array_list;
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
}
