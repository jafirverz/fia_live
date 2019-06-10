<?php

use App\SystemSetting;
use App\Page;
use App\Menu;
use Illuminate\Support\Arr;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function setting()
    {
        $setting = SystemSetting::orderBy('id', 'desc')->first();
        return $setting;
    }

    function getMenus($id)
    {
        $menus = [];
        $details = Menu::leftJoin('pages', 'menus.page_id', '=', 'pages.id')
            ->where('pages.status',1)
            ->where('menus.status',1)
            ->orderBy('menus.view_order', 'ASC')
            ->select('menus.*', 'pages.name', 'pages.slug')
            ->get();
        if ($details->count()) {
            $filterData = $details->filter(function ($detail) {
                if ($detail->child != 0) {
                    $result = checkChildMenus($detail->id);
                    if ($result->count()) {
                        return $detail;
                    } elseif ($detail->slug != null) {
                        return $detail;
                    }
                } elseif ($detail->slug != null) {
                    return $detail;
                }
            });

            $menus = $filterData->groupBy('parent')->toArray();
        }
        return $menus;
    }

    function checkChildMenus($id)
    {
        $details = Menu::leftJoin('pages', 'menus.page_id', '=', 'pages.id')
            ->orderBy('menus.view_order', 'ASC')
            ->where('menus.parent', $id)
            ->select('menus.*', 'pages.name', 'pages.slug')
            ->get();
        $filterData = collect([]);
        if ($details->count()) {
            $filterData = $details->filter(function ($detail) {
                if ($detail->child != 0) {
                    $result = checkChildMenus($detail->id);
                    if ($result->count()) {
                        return $detail;
                    } elseif ($detail->slug != null) {
                        return $detail;
                    }
                } elseif ($detail->slug != null) {
                    return $detail;
                }
            });
        }
        return $filterData;

    }

    function getBreadcrumb($page)
    {
        $main_menu = [$page->id];
        $breadcrumbs = [];
        $menus = Menu::join('pages', 'pages.id', '=', 'menus.child')->where('menus.child', $page->id)->orderBy('menus.view_order')->get();
        //return $menus;
        if ($menus->count()) {
            foreach ($menus as $menu) {
                $main_menu[] = $menu->page_id;
            }
        }

        //return $main_menu;

        if ($main_menu) {
            $page = Page::where('slug', 'home')->first();
            $breadcrumbs[] = [
                'slug' => $page->slug,
                'title' => $page->name,
            ];
            foreach ($main_menu as $values) {
                if ($values) {
                    $page = Page::find($values);
                    $breadcrumbs[] = [
                        'slug' => $page->slug,
                        'title' => $page->name,
                    ];
                }
            }
        }
        return $breadcrumbs;
    }

    function ObjectDelete($object)
    {
        try {
            $object->delete();
            return true;
        } catch (QueryException $e) {

            if ($e->getCode() == __('constant.INTEGRITY_VIOLATION')) { //23000 is sql code for integrity constraint violation
                return false;
            }
        }
    }

    function RDP($detail)
    {
        $secret_key = env('RDP_SECRET_KEY');
        $m_id = env('RDP_MID');

        $request_transaction = [
            "api_mode" => "redirection_hosted",
            "redirect_url" => "http://verz1.com/rdp.php",
            "notify_url" => "http://verz1.com/rdp.php",
            "back_url" => "http://verz1.com/rdp.php",
            "mid" => $m_id,
            "payment_type" => "S",
        ];
        $request_transaction['merchant_reference'] = $detail['merchant_reference'];
        $request_transaction['payer_name'] = $detail['payer_name'];
        $request_transaction['payer_email'] = $detail['payer_email'];
        $request_transaction['card_no'] = $detail['card_no'];
        $request_transaction['exp_date'] = $detail['exp_date'];
        $request_transaction['cvv2'] = $detail['cvv2'];
        $request_transaction['order_id'] = $detail['order_id'];
        $request_transaction['amount'] = $detail['amount'];
        $request_transaction['ccy'] = $detail['ccy'];


        /* given $params contains the parameters you would like to sign */
        $fields_for_sign = array('mid', 'order_id', 'payment_type', 'amount', 'ccy');
        $aggregated_field_str = "";
        foreach ($fields_for_sign as $f) {
            $aggregated_field_str .= trim($request_transaction[$f]);
        }
        $aggregated_field_str .= $secret_key;
        $signature = hash('sha512', $aggregated_field_str);


        $request_transaction['signature'] = $signature;

        $json_request = json_encode($request_transaction);

        $response = postRDP($json_request);
        //dd($response);
        $response_array = json_decode($response, true);
        return $response_array;

    }

    function postRDP($json_request)
    {
        $url = env('RDP_API');
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => $json_request,
            CURLOPT_HTTPHEADER =>
                array('Content-Type: application/json')
        ));
        $response = curl_exec($curl);
        $curl_errno = curl_errno($curl);
        $curl_err = curl_error($curl);
        curl_close($curl);

        return $response;
    }

    function getSelectedMenus($menuId, $pageId = 1)
    {

        $page = Page::find($pageId);
        if ($menuId) {
            $menu = Menu::find($menuId);

        } elseif ($pageId != 1) {
            $menu = Menu::where('id', $page->parent)->first();
            if (!$menu) {
                $menu = Menu::where('page_id', __('constant.HOME_PAGE_ID'))->first();
            }

        } else {
            $menu = Menu::where('page_id', __('constant.HOME_PAGE_ID'))->first();

        }

        if (session('menu_id') != $menu->id) {
            Session::forget('menu_id');
        }

        $menus = [];
        if (!$menu) {
            $menu = Menu::where('id', 1)->first();
        }
        $menus[] = $menu->id;
        $parentMenuId = $menu->parent;
        while ($parentMenuId != 0) {
            $menu = Menu::find($parentMenuId);
            $menus[] = $menu->id;
            $parentMenuId = $menu->parent;
        }

        //menus store in session
        return $menus;
    }


    function getParentPages($id)
    {
        $details = Page::orderBy('parent', 'ASC')
            ->orderBy('name', 'ASC')
            ->select('name', 'id', 'child', 'parent')
            ->where('parent', $id)
            ->whereNotNull('child')
            ->get();
        return $details;
    }

    function setOption($id, $pageParent = null, $parent = 0)
    {
        $parentPages = getParentPages($id);
        if (count($parentPages)) {
            foreach ($parentPages as $key => $p) {
                if ($pageParent == $p->id) {
                    ?>
                    <option value='<?php echo $p->id; ?>' selected="selected">
                    <?php
                } else {
                    ?>
                    <option value='<?php echo $p->id; ?>' >
                    <?php
                }
                ?>

                <?php
                for ($i = 1; $i <= $parent; $i++) {
                    echo "&emsp;";
                }
                echo $p->name . "</option>";
                if ($p->child == 1) {
                    setOption($p->id, $pageParent, $parent + 1);
                }
            }
        }
    }
}
