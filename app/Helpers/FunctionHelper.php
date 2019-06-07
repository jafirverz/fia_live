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
