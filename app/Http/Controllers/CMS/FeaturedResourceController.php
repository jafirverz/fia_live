<?php
namespace App\Http\Controllers\CMS;
use App\Podcast;
use App\Filter;
use App\ThinkingPiece;
use App\TopicalReport;
use App\FeatureResource;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Auth;


class FeaturedResourceController extends Controller

{


    public function __construct()

    {
        $this->middleware('auth:admin');
        $this->module_name = 'FEATURED_RESOURCE';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.FEATURED_RESOURCE');
		$featured_1=$featured_2=$featured_3=[];
		$featureResource = FeatureResource::findorfail(1);
		if($featureResource->featured_1_type==1)
		$featured_1 = TopicalReport::all();
		elseif($featureResource->featured_1_type==2)
		$featured_1 = Podcast::all();
		elseif($featureResource->featured_1_type==3)
		$featured_1 = ThinkingPiece::all();
		
		if($featureResource->featured_2_type==1)
		$featured_2 = TopicalReport::all();
		elseif($featureResource->featured_2_type==2)
		$featured_2 = Podcast::all();
		elseif($featureResource->featured_2_type==3)
		$featured_2 = ThinkingPiece::all();
		
		if($featureResource->featured_3_type==1)
		$featured_3 = TopicalReport::all();
		elseif($featureResource->featured_3_type==2)
		$featured_3 = Podcast::all();
		elseif($featureResource->featured_3_type==3)
		$featured_3 = ThinkingPiece::all();
		
        return view("admin.featured-resource.index", compact("title","featureResource","featured_1","featured_2","featured_3"));
    }


   public function detail(Request $request)
   {
	  $option=[]; 
	  if($request->feature==1)
	  {
		 $TopicalReports = TopicalReport::all();
		 foreach($TopicalReports as $key=>$items)
		 {
		  $option[]='<option value="'.$items->id.'">'.$items->title.'</option>'; 	 
	     }		 
		 return implode('',$option);
	  }
	  elseif($request->feature==2)
	  {
		 $podcasts = Podcast::all();
		 
		 foreach($podcasts as $key=>$items)
		 {
		  $option[]='<option value="'.$items->id.'">'.$items->title.'</option>'; 	 
	     }
		 
		 return implode('',$option);
	  }
	  elseif($request->feature==3)
	  {
		 $thinkPieces = ThinkingPiece::all();
		 foreach($thinkPieces as $key=>$items)
		 {
		  $option[]='<option value="'.$items->id.'">'.$items->thinking_piece_title.'</option>'; 	 
	     }
		
		 return implode('',$option);
	  }
	   
   }

   


    public function update(Request $request)

    {
       // dd($request);        
		
		$validatorFields = [
                'featured_1' => 'required_unless:featured_1_type,null',
				'featured_2' => 'required_unless:featured_2_type,null',
                'featured_3' => 'required_unless:featured_3_type,null'
            ];
        //dd($request);
        $this->validate($request, $validatorFields);
		
		$featureResource = FeatureResource::findorfail(1);
		
        $featureResource->featured_1_type = $request->featured_1_type;
		$featureResource->featured_1 =($request->featured_1_type!='null')?$request->featured_1:0;
        $featureResource->featured_2_type =  $request->featured_2_type;
		$featureResource->featured_2 = ($request->featured_2_type!='null')?$request->featured_2:0;
		$featureResource->featured_3_type =  $request->featured_3_type;
		$featureResource->featured_3 = ($request->featured_3_type!='null')?$request->featured_3:0;
		$featureResource->updated_at = Carbon::now()->toDateTimeString();
        $featureResource->save();

        return redirect(route('featured-resources.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.FEATURED_RESOURCE')]));


    }


    }

