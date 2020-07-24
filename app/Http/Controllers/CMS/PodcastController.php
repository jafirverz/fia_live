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
use Image;
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

        return view("admin.podcast.index", compact("events", "title", "podcasts"));
    }




    public function create()

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');

        $topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
        return view("admin.podcast.create", compact("title", "topics"));
    }


    public function edit($id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');

        $podcast = Podcast::findorfail($id);
        $topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
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
            'audio_file' => 'nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'podcast_image' => 'nullable|image|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
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


        if (!is_dir('uploads/podcast')) {
            mkdir('uploads/podcast');
        }
        if (!is_dir('uploads/podcast/thumb')) {
            mkdir('uploads/podcast/thumb');
        }
        if (!is_dir('uploads/podcast/social')) {
            mkdir('uploads/podcast/social');
        }
        $destinationPath = 'uploads/podcast'; // upload path
        $podcast_image = '';
        $podcast_imagePath = null;
        if ($request->hasFile('podcast_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('podcast_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('podcast_image')->getClientOriginalExtension();
            // Filename to store
            $podcast_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('podcast_image')->move($destinationPath, $podcast_image);
            $podcast_imagePath = $destinationPath . "/" . $podcast_image;
            /*Crop Image*/
            $thumb_img = Image::make($destinationPath . '/' . $podcast_image)->resize(125, 125);
            $thumb_img->save($destinationPath . '/thumb/' . $podcast_image);
            $podcast->thumb_image = $destinationPath . '/thumb/' . $podcast_image;

            //social image
            $socialImage = Image::make($destinationPath . '/' . $podcast_image)->resize(376, 376);
            $socialImage->save($destinationPath . '/social/' . $podcast_image);
            $podcast->social_image = $destinationPath . '/social/' . $podcast_image;
            /*Crop Image saved*/

            $podcast->podcast_image = $podcast_imagePath;
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
            'audio_file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'podcast_image' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
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
        if (!is_dir('uploads/podcast')) {
            mkdir('uploads/podcast');
        }
        $destinationPath = 'uploads/podcast'; // upload path
        $podcast_image = '';
        $podcast_imagePath = null;
        if ($request->hasFile('podcast_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('podcast_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('podcast_image')->getClientOriginalExtension();
            // Filename to store
            $podcast_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('podcast_image')->move($destinationPath, $podcast_image);
            $podcast_imagePath = $destinationPath . "/" . $podcast_image;
            /*Crop Image*/
            $thumb_img = Image::make($destinationPath . '/' . $podcast_image)->crop(200, 200, 100, 100);
            $thumb_img->save($destinationPath . '/thumb/' . $podcast_image);
            $podcast->thumb_image = $destinationPath . '/thumb/' . $podcast_image;
            /*Crop Image saved*/

            //social image
            $socialImage = Image::make($destinationPath . '/' . $podcast_image)->crop(376, 376, 100, 100);
            $socialImage->save($destinationPath . '/social/' . $podcast_image);
            $podcast->social_image = $destinationPath . '/social/' . $podcast_image;

            $podcast->podcast_image = $podcast_imagePath;
        }
        $podcast->save();


        return redirect(route('podcast.index'))->with('success', __('constant.CREATED', ['module' => __('constant.PODCAST')]));
    }
}
