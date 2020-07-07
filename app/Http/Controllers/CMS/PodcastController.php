<?php


namespace App\Http\Controllers\CMS;
use App\Podcast;
use App\Filter;
use App\TopicalReportCountry;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Auth;


class PodcastController extends Controller

{


    public function __construct()

    {
        $this->middleware('auth:admin');
        $this->module_name = 'PODCAST';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.PODCAST');

        $podcasts = Podcast::all();

        return view("admin.podcast.index", compact("events", "title","podcasts"));


    }




    public function create()

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');

		$topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name','ASC')->get();
        return view("admin.podcast.create", compact("title", "topics"));

    }


    public function edit($id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');

        $podcast = Podcast::findorfail($id);
        $topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name','ASC')->get();
        return view("admin.podcast.edit", compact("title", "podcast", "topics"));

    }


    public function show($id)

    {

        //

    }

    public function update(Request $request, $id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $podcast = Podcast::findorfail($id);        
		$validatorFields = [
                'topical_id' => 'required',
				'title' => 'required',
				'pdf' => 'nullable|mimes:pdf',
                'description' => 'required'
            ];


        $this->validate($request, $validatorFields);
		
        $podcast->topical_id = json_encode($request->topical_id);
        $podcast->title = $request->title;
		$podcast->description = $request->description;
		
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/audio')) {
            mkdir('uploads/audio');
        }
        $destinationPath = 'uploads/audio'; // upload path
        $audio_url = '';
        $audioPath = null;
        if ($request->hasFile('audio_file')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('audio_file')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('audio_file')->getClientOriginalExtension();
            // Filename to store
            $audio_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('audio_file')->move($destinationPath, $audio_url);
            $audioPath = $destinationPath . "/" . $audio_url;
			$podcast->audio_file = $audioPath;
        }
       
		
        $podcast->updated_at = Carbon::now()->toDateTimeString();
        $podcast->save();

		
		
		
        return redirect(route('podcast.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.PODCAST')]));


    }


    public function destroy($id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $podcast = Podcast::findorfail($id);
        $podcast->delete();
        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.PODCAST')]));

    }

   
    


    public function store(Request $request)
    {

         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $validatorFields = [
                'topical_id' => 'required',
				'title' => 'required',
				'audio_file' => 'nullable|mimes:pdf',
                'description' => 'required'

            ];




        $this->validate($request, $validatorFields);
		$podcast = new Podcast;
		$podcast->topical_id = json_encode($request->topical_id);
        $podcast->title = $request->title;
		$podcast->description = $request->description;
		
		
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/audio')) {
            mkdir('uploads/audio');
        }
        $destinationPath = 'uploads/audio'; // upload path
        $audio_url = '';
        $audioPath = null;
        if ($request->hasFile('audio_file')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('audio_file')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('audio_file')->getClientOriginalExtension();
            // Filename to store
            $audio_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('audio_file')->move($destinationPath, $audio_url);
            $audioPath = $destinationPath . "/" . $audio_url;
			$podcast->audio_file = $audioPath;
        }
        
		$podcast->save();
		
		
        return redirect(route('podcast.index'))->with('success', __('constant.CREATED', ['module' => __('constant.PODCAST')]));

        }

    }
