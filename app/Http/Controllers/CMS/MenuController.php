<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Menu;
use App\Page;
use Carbon\Carbon;
use Auth;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'MENU';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $parent = 0;
        $parentMenu = null;
        $title = __('constant.MENU');
        $menus = Menu::where('parent', 0)
            ->orderBy('view_order', 'ASC')
            ->get();
        return view('admin.menu.index', compact('title', 'menus', 'parent', 'parentMenu'));
    }

    public function getSubMenus($id)
    {
        $title = __('constant.MENU');
        $menus = Menu::where('parent', $id)
            ->orderBy('view_order', 'ASC')
            ->get();
        $parent = 0;
        $parentMenu = null;
        if (!empty($id)) {
            $parentMenu = Menu::findorfail($id);
            $parent = $id;
        }
        return view('admin.menu.index', compact('title', 'menus', 'id', 'parent', 'parentMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');
        $parentMenu = Menu::where('id', $request->parent)->first();
        $viewOrderMenu = Menu::where('parent', $request->parent)->orderBy('view_order', 'DESC')->first();
        $viewOrder = 0;
        if ($viewOrderMenu) {
            $viewOrder = $viewOrderMenu->view_order + 1;
        }
        /*Please do not remove this comment its imp*/
        /*$pageMenus = Menu::whereNotNull('page_id')->get();
        $query = Page::where('status', 1)->orderBy('name','asc');
        if ($pageMenus->count()) {
            $pageIds = $pageMenus->pluck('page_id')->all();
            if (count($pageIds)) {
                $query = $query->whereNotIn('id', $pageIds);
            }
        }
        $pages = $query->get();*/
        $pages = Page::where('status', 1)->orderBy('name', 'asc')->get();


        $parent = $request->parent;

        return view('admin.menu.create', compact('title', 'parentMenu', 'parent', 'pages', 'viewOrder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $fields = $request->all();
        $validatorFields = [
            'title' => 'required|max:191',
        ];

        $validator = Validator::make($fields, $validatorFields);
        $validator->sometimes('title', 'required|unique:menus', function ($input) {
            if (Menu::where('title', ucfirst($input->title))
                ->where('parent', '=', $input->parent)
                ->exists()
            ) {
                return true;
            }
        });

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $menu = new Menu;
        $menu->title = ucfirst($request->title);
        if ($request->page_id !='null') {
            $menu->page_id = $request->page_id;
        } else {
            $menu->page_id = null;
        }
        $menu->parent = $request->parent;
        if (!is_null($request->status)) {
            $menu->status = 1;
        } else {
            $menu->status = $request->status;
        }
        $menu->view_order = $request->view_order;
        $menu->child = 0;
        $mainMenuId = 0;


        if ($request->parent != 0) {
            $parentId = $request->parent;

            do {
                $parentMenu = Menu::where('id', $parentId)->first();
                if (!$parentMenu) {
                    $parentId = 0;
                    $mainMenuId = 0;
                } elseif ($parentMenu->parent != 0) {
                    $parentId = $parentMenu->parent;
                } else {
                    $parentId = 0;
                    $mainMenuId = $parentMenu->id;
                }
            } while ($parentId != 0);
            $parentMenu = Menu::where('id', $request->parent)->first();
            if ($parentMenu) {
                $parentMenu->child = 1;
                $parentMenu->save();
            }
        }
        $menu->main = $mainMenuId;
        $menu->created_at = Carbon::now()->toDateTimeString();
        $menu->save();

        return redirect(route('get-sub-menu', ['id' => $request->parent]))->with('success', __('constant.CREATED', ['module' => __('constant.MENU')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $menu = Menu::findorfail($id);
        $parentMenu = Menu::find($request->parent);
        if (!empty($request->parent) && is_null($parentMenu)) {
            return redirect()->action('CMS\MenuController@index')->with('error', __('constant.OPPS'));
        }
        /*Please do not remove this comment its imp*/
        /*$pageMenus = Menu::whereNotNull('page_id')->whereNotIn('id', [$id])->get();
        $query = Page::where('status', 1)->orderBy('name','asc');
        if ($pageMenus->count()) {
            $pageIds = $pageMenus->pluck('page_id')->all();
            if (count($pageIds)) {
                $query = $query->whereNotIn('id', $pageIds);
            }
        }

        $pages = $query->get();*/

        $pages = Page::where('status', 1)->orderBy('name', 'asc')->get();
        $parent = $request->parent;
        return view('admin.menu.edit', compact('title', 'menu', "parentMenu", 'parent', 'pages'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $menu = Menu::findorfail($id);
        $fields = $request->all();
        $validatorFields = [
            'title' => 'required|max:191',
        ];

        $validator = Validator::make($fields, $validatorFields);
        $validator->sometimes('title', 'required|unique:menus', function ($input) use ($id) {
            if (Menu::where('title', ucfirst($input->title))
                ->where('parent', '=', $input->parent)
                ->whereNotIn('id', [$id])
                ->exists()
            ) {
                return true;
            }
        });

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $menu->title = ucfirst($request->title);
        if ($request->page_id !='null') {
            $menu->page_id = $request->page_id;
        } else {
            $menu->page_id = null;
        }
        $menu->parent = $request->parent;
        if (isset($request->status)) {
            $menu->status = $request->status;
        }
        $menu->view_order = $request->view_order;
        $menu->child = 0;
        $mainMenuId = 0;


        if ($request->parent != 0) {
            $parentId = $request->parent;

            do {
                $parentMenu = Menu::where('id', $parentId)->first();
                if (!$parentMenu) {
                    $parentId = 0;
                    $mainMenuId = 0;
                } elseif ($parentMenu->parent != 0) {
                    $parentId = $parentMenu->parent;
                } else {
                    $parentId = 0;
                    $mainMenuId = $parentMenu->id;
                }
            } while ($parentId != 0);
            $parentMenu = Menu::where('id', $request->parent)->first();
            if ($parentMenu) {
                $parentMenu->child = 1;
                $parentMenu->save();
            }
        }
        $menu->main = $mainMenuId;
        $menu->updated_at = Carbon::now()->toDateTimeString();
        $menu->save();

        return redirect(route('get-sub-menu', ['id' => $request->parent]))->with('success', __('constant.UPDATED', ['module' => __('constant.MENU')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $menu = Menu::findorfail($id);


        $childIds = [$menu->id];
        $ids = $childIds;
        do {
            $childMenus = Menu::whereIn('parent', $childIds)->get();

            if ($childMenus->count()) {
                $childIds = $childMenus->pluck('id')->all();
                $ids = array_values(array_merge($ids, $childIds));
            } else {
                $childIds = [];
            }
        } while (count($childIds) != 0);

        if (count($ids)) {
            Menu::whereIn('id', $ids)->delete();
            //store log of activity
            $ids = json_encode($ids);

        }
        $parentChildMenus = Menu::where('parent', $menu->parent)->get();
        if (!$parentChildMenus->count()) {
            $parentMenu = Menu::find($menu->parent);
            $parentMenu->child = 0;
            $parentMenu->save();

        }
        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.MENU')]));
    }


}
