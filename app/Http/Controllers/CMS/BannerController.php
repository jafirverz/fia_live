<?php
namespace App\Http\Controllers\CMS;
use App\Banner;
use App\Page;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Validator;



class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'BANNER';
    }

    public function typeIndex()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.BANNER');
        return view('admin.banner.type', compact('title'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type=null)
    {

        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.BANNER');
        if($type==__('constant.BANNER_TYPE_HOME')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('page_name',1)->get();
            return view('admin.banner.index', compact('title', 'banners','type'));
        }else if($type==__('constant.BANNER_TYPE_OTHER')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('page_name','!=',1)->get();
            return view('admin.banner.index', compact('title', 'banners','type'));
        }else{
            return view('admin.banner.type', compact('title','type'));
        }

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
        $type = $request->type;
        //$viewOrderBanner = Banner::orderBy('view_order', 'DESC')->first();
        $viewOrderBanner = null;
        $viewOrder = 0;
        if ($viewOrderBanner) {
            $viewOrder = $viewOrderBanner->view_order + 1;
        }
        if($type==__('constant.BANNER_TYPE_HOME')){
            $pages = Page::select('id', 'title')->where('status', 1)->where('id',1)->get();
        }else if($type==__('constant.BANNER_TYPE_OTHER')){
            $pages = Page::select('id', 'title')->where('status', 1)->where('id','!=',1)->get();
        }


        return view('admin.banner.create', compact('title', 'pages', 'viewOrder','type'));
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


        $request->validate([
            'page_name' => 'required|max:191',
            'banner_image' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
            'banner_link' => 'required_if:page_name,==,1|nullable|url'
        ],['banner_link.required_if'=>'Please enter proper link.']);

        $type = $request->type;
        $page = Page::select('id', 'title')->where('status', 1)->where('id',$request->page_name)->first();
        if($type==__('constant.BANNER_TYPE_HOME')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('page_name',1)->get();
            if($banners->count()>=5)
            {
                return redirect( url("admin/banner/type",["type"=>$type]))->with('error','You can add maximum five banner for '.$page->title);
            }
        }else if($type==__('constant.BANNER_TYPE_OTHER')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('page_name',$request->page_name)->get();
            if($banners->count()>=1)
            {
                return redirect( url("admin/banner/type",["type"=>$type]))->with('error', 'You can add maximum one banner for '.$page->title);
            }
        }


        $banner = new Banner;
        $banner->page_name = $request->page_name;

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/banners')) {
            mkdir('uploads/banners');
        }
        $destinationPath = 'uploads/banners'; // upload path
        $banner_image = '';
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('banner_image')->move($destinationPath, $banner_image);
            $bannerPath = $destinationPath . "/" . $banner_image;;
        }
        $banner->banner_image = $bannerPath;

        $banner->banner_link = ($request->banner_link?$request->banner_link:'');
		$banner->target = ($request->target?$request->target:'');
		$banner->caption = ($request->caption?$request->caption:'');
		$banner->order_by =($request->order_by?$request->order_by:0);
		$banner->created_at = Carbon::now()->toDateTimeString();
        $banner->save();

        return redirect( url("admin/banner/type",["type"=>$type]))->with('success', __('constant.CREATED', ['module' => __('constant.BANNER')]));
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
    public function edit($id,Request $request)
    {
        $type = $request->type;
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        if($type==__('constant.BANNER_TYPE_HOME')){
            $pages = Page::select('id', 'title')->where('status', 1)->where('id',1)->get();
        }else if($type==__('constant.BANNER_TYPE_OTHER')){
            $pages = Page::select('id', 'title')->where('status', 1)->where('id','!=',1)->get();
        }
        $title = __('constant.EDIT');
        $banner = Banner::findorfail($id);
        return view('admin.banner.edit', compact('title', 'banner', 'pages','type'));
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
        $banner = Banner::findorfail($id);
        $type = $request->type;
         $request->validate([
            'page_name' => 'required|max:191',
            'banner_image' => 'image|nullable|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
			'banner_link' => 'required_if:page_name,==,1|nullable|url'
        ],['banner_link.required_if'=>'Please enter proper link.']);

        if($type==__('constant.BANNER_TYPE_HOME')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('id','!=',$id)->where('page_name',1)->get();
            if($banners->count()>=5)
            {
                return redirect( url("admin/banner/type",["type"=>$type]))->with('error','You can add maximum five banner');
            }
        }else if($type==__('constant.BANNER_TYPE_OTHER')){
            $banners = Banner::orderBy('page_name','ASC')->orderBy('order_by','ASC')->where('id','!=',$id)->where('page_name',$request->page_name)->get();
            if($banners->count()>=1)
            {
                return redirect( url("admin/banner/type",["type"=>$type]))->with('error', 'You can add maximum one banner');
            }
        }

        $banner->page_name = $request->page_name;

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/banners')) {
            mkdir('uploads/banners');
        }
        $destinationPath = 'uploads/banners'; // upload path
        $banner_image = '';
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('banner_image')->move($destinationPath, $banner_image);
        }


        if ($request->hasFile('banner_image')) {
            if ($banner->banner_image) {
                File::delete($banner->banner_image);
            }
            $bannerPath = $destinationPath . '/' . $banner_image;
            $banner->banner_image = $bannerPath;
        }

        $banner->banner_link = ($request->banner_link?$request->banner_link:'');
		$banner->target = ($request->target?$request->target:'');
		$banner->caption = ($request->caption?$request->caption:'');
		$banner->order_by =($request->order_by?$request->order_by:0);
		$banner->updated_at = Carbon::now()->toDateTimeString();
        $banner->save();

        return redirect( url("admin/banner/type",["type"=>$type]))->with('success', __('constant.UPDATED', ['module' => __('constant.BANNER')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $type = $request->type;
         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $banner = Banner::findorfail($id);
        $banner->delete();

        return redirect( url("admin/banner/type",["type"=>$type]))->with('success', __('constant.REMOVED', ['module' => __('constant.BANNER')]));
    }
}
