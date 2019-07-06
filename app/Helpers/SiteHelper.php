<?php

use App\SystemSetting;
use App\Page;
use App\Menu;
use App\Banner;
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
                'title' => $page->title,
            ];
            foreach ($main_menu as $values) {
                if ($values) {
                    $page = Page::find($values);
                    $breadcrumbs[] = [
                        'slug' => $page->slug,
                        'title' => $page->title,
                    ];
                }
            }
        }
		//dd($breadcrumbs);
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
	function get_page_banner($page_id)
	{
	//dd($page_id);	
	$banner = Banner::where('page_name', $page_id)->first();
	if(isset($banner) && $banner->count()>0)	
	return $banner;
	else
	return "";
	}
    function pageDetails($slug)
	{
	$details = Page::where('slug', $slug)->where('status','1')->first();
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
