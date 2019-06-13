<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'PAGE';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.PAGE');
        $pages = Page::all();
        return view('admin.page.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');

        return view('admin.page.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $fields = $request->all();
        $request['slug'] = str_slug($request->slug, '-');
        $validatorFields = [
            'title' => 'required|max:191',
            'slug' => 'required|unique:pages,slug|max:191',
            'contents' => 'required',
        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $page = new Page;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->contents = $request->contents;
        /*$page->meta_title = $request->meta_title;
        $page->meta_auther = $request->meta_auther;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;*/
        $page->page_type = 0;
        if (empty($request->status)) {
            $page->status = 1;
        } else {
            $page->status = $request->status;
        }
        $page->save();

        return redirect('admin/page')->with('success', __('constant.CREATED', ['module' => __('constant.PAGE')]));
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
    public function edit($id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $page = Page::findorfail($id);
        return view('admin.page.edit', compact('title', 'page'));
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

       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $fields = $request->all();
        $request['slug'] = str_slug($request->slug, '-');
        $validatorFields = [
            'title' => 'required|max:191',
            'slug' => 'required|max:191|unique:pages,slug,' . $id . ',id',
            'contents' => 'required',
        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $page = Page::findorfail($id);
        $page->title = $request->title;
        $page->slug = $request->slug;        
        $page->contents = $request->contents;
        /*$page->meta_title = $request->meta_title;
        $page->meta_auther = $request->meta_auther;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;*/
        
        $page->save();

        return redirect('admin/page')->with('success', __('constant.UPDATED', ['module' => __('constant.PAGE')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $page = Page::findorfail($id);
        $page->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.PAGE')]));
    }


}
