<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
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
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
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
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
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
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
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
		$page->other_contents1 = isset($request->other_contents1)?$request->other_contents1:"";
		$page->other_contents2 = isset($request->other_contents2)?$request->other_contents2:"";
		$page->other_contents3 = isset($request->other_contents3)?$request->other_contents3:"";
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
		$page->created_at = Carbon::now()->toDateTimeString();
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
         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
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

          is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $fields = $request->all();
        $request['slug'] = str_slug($request->slug, '-');
        $validatorFields = [
            'title' => 'required|max:191',
            'slug' => 'required|max:191|unique:pages,slug,' . $id . ',id',
            'contents' => 'required',
			'video1' => 'nullable|mimes:mp4',
			'video2' => 'nullable|mimes:mp4',
        ];
        $validator = Validator::make($fields, $validatorFields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $page = Page::findorfail($id);
        $page->title = $request->title;
        $page->slug = $request->slug;        
        $page->contents = $request->contents;
		$page->other_contents1 = isset($request->other_contents1)?$request->other_contents1:"";
		$page->other_contents2 = isset($request->other_contents2)?$request->other_contents2:"";
		$page->other_contents3 = isset($request->other_contents3)?$request->other_contents3:"";
		
		//Video Upload
		if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/video')) {
            mkdir('uploads/video');
        }
        $destinationPath = 'uploads/video'; // upload path
        $video1_url = '';
		$video2_url = '';
        $video1Path = null;
		$video2Path = null;
		
		if ($request->hasFile('video1')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('video1')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('video1')->getClientOriginalExtension();
            // Filename to store
            $video1_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('video1')->move($destinationPath, $video1_url);
            $video1Path = $destinationPath . "/" . $video1_url;;
        }
        if ($request->hasFile('video1')) {
            if ($page->video1) {
                File::delete($page->video1);
            }
            $video1Path = $destinationPath . '/' . $video1_url;
            $page->video1 = $video1Path;
        }
		
		if ($request->hasFile('video2')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('video2')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('video2')->getClientOriginalExtension();
            // Filename to store
            $video2_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('video2')->move($destinationPath, $video2_url);
            $video2Path = $destinationPath . "/" . $video2_url;;
        }
        if ($request->hasFile('video2')) {
            if ($page->video2) {
                File::delete($page->video2);
            }
            $video2Path = $destinationPath . '/' . $video2_url;
            $page->video2 = $video2Path;
        }
		
		//End Video Upload
		
        /*$page->meta_title = $request->meta_title;
        $page->meta_auther = $request->meta_auther;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;*/
        $page->updated_at = Carbon::now()->toDateTimeString();
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
         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $page = Page::findorfail($id);
        $page->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.PAGE')]));
    }


}
