<?php


namespace App\Http\Controllers\CMS;

use App\TopicalReport;
use App\Filter;
use App\TopicalReportCountry;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use Auth;


class TopicalReportController extends Controller

{


    public function __construct()

    {
        $this->middleware('auth:admin');
        $this->module_name = 'TOPICAL_REPORT';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.TOPICAL_REPORT');

        $TopicalReports = TopicalReport::all();

        return view("admin.topical_report.index", compact("events", "title","TopicalReports"));


    }




    public function create()

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');

		$topics = Filter::where('filter_name', 2)->where('status', 1)->get();
		$countries = Filter::where('filter_name', 1)->where('status', 1)->get();
        return view("admin.topical_report.create", compact("title", "topics","countries"));

    }


    public function edit($id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');

        $topicalReport = TopicalReport::findorfail($id);

        $topics = Filter::where('filter_name', 2)->where('status', 1)->get();
		$countries = Filter::where('filter_name', 1)->where('status', 1)->get();
        return view("admin.topical_report.edit", compact("title", "topics","topicalReport","countries"));

    }


    public function show($id)

    {

        //

    }

    public function update(Request $request, $id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $TopicalReport = TopicalReport::findorfail($id);


        
		$validatorFields = [
				'country_id'  =>  'required',
                'topical_id' => 'required',
				'title' => 'required',
                'description' => 'required'
            ];


        $this->validate($request, $validatorFields);
		
        $TopicalReport->topical_id = json_encode($request->topical_id);
        $TopicalReport->title = $request->title;
		$TopicalReport->description = $request->description;
		/*if($request->banner_image)
        {
            $TopicalReport->banner_image = $request->banner_image;
        }*/
        if($request->pdf)
        {
            $TopicalReport->pdf = $request->pdf;
        }
        $TopicalReport->updated_at = Carbon::now()->toDateTimeString();
        $TopicalReport->save();

		if(count($request->country_id)>0)
		{
				DB::table('topical_report_countries')->where('topical_report_id', $id)->delete(); 
				 foreach($request->country_id as $country)
				 {
				 $TopicalReportCountry = new TopicalReportCountry;	
				 $TopicalReportCountry->topical_report_id = $TopicalReport->id;
				 $TopicalReportCountry->filter_id = $country;
				 $TopicalReportCountry->save();
				 }
		}
		
		
        return redirect(route('topical_report.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.TOPICAL_REPORT')]));


    }


    public function destroy($id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $event = TopicalReport::findorfail($id);
        $event->delete();
        DB::table('topical_report_countries')->where('topical_report_id', $id)->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.TOPICAL_REPORT')]));

    }

   
    


    public function store(Request $request)
    {

        
        $validatorFields = [
				'country_id'  =>  'required',
                'topical_id' => 'required',
				'title' => 'required',
                'description' => 'required'

            ];




        $this->validate($request, $validatorFields);
		$TopicalReport = new TopicalReport;
		$TopicalReport->topical_id = json_encode($request->topical_id);
        $TopicalReport->title = $request->title;
		$TopicalReport->description = $request->description;
		
		/*if($request->banner_image)
        {
            $TopicalReport->banner_image = $request->banner_image;
        }*/
        if($request->pdf)
        {
            $TopicalReport->pdf = $request->pdf;
        }
		$TopicalReport->save();
		
		if(count($request->country_id)>0)
		{
				 foreach($request->country_id as $country)
				 {
				 $TopicalReportCountry = new TopicalReportCountry;	
				 $TopicalReportCountry->topical_report_id = $TopicalReport->id;
				 $TopicalReportCountry->filter_id = $country;
				 $TopicalReportCountry->save();
				 }
		}
        return redirect(route('topical_report.index'))->with('success', __('constant.CREATED', ['module' => __('constant.TOPICAL_REPORT')]));

        }

    }

