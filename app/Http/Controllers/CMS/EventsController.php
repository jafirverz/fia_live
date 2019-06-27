<?php


namespace App\Http\Controllers\CMS;

use App\Event;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use Auth;


class EventsController extends Controller

{


    public function __construct()

    {
        $this->middleware('auth:admin');
        $this->module_name = 'EVENT';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.EVENT');

        $events = Event::orderBy('event_date', 'desc')->get();

        return view("admin.events.index", compact("events", "title"));


    }




    public function create()

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');



        return view("admin.events.create", compact("title", "Events_type", "Teachers"));

    }


    public function edit($id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');

        $event = Event::findorfail($id);

       

        return view("admin.events.edit", compact("title", "event"));

    }


    public function show($id)

    {

        //

    }

    public function update(Request $request, $id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $event = Event::findorfail($id);


        

            $validatorFields = [

                'event_title' => 'required|unique:events,event_title,' . $id,
                'description' => 'required',
                'event_date' => 'required|date',
                'oth_date' => 'nullable|date',
                'event_address' => 'required',
                'event_image' => 'nullable|image'

            ];


       

        $this->validate($request, $validatorFields);
        $event->event_title = $request->event_title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
		if($request->event_image)
        {
            $event->event_image = $request->event_image;
        }
        $event->event_address = $request->event_address;
        $event->updated_at = Carbon::now()->toDateTimeString();
        $event->save();


        return redirect(route('events.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.EVENT')]));


    }


    public function destroy($id)

    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $event = Event::findorfail($id);

        $event->delete();

        DB::table('events')->where('id', $id)->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.EVENT')]));

    }

   
    


    public function store(Request $request)
    {

        
        $validatorFields = [

                'event_title' => 'required|unique:events,event_title',
                'description' => 'required',
                'event_date' => 'required|date',
                'oth_date' => 'nullable|date',
                'event_address' => 'required',
                'event_image' => 'required|image'

            ];




        $this->validate($request, $validatorFields);
		$event = new Event;
		$event->event_title = $request->event_title;
		$event->description = $request->description;
		$event->event_date = $request->event_date;
		$event->event_address = $request->event_address;
		if($request->event_image)
        {
            $event->event_image = $request->event_image;
        }
		$event->save();
        return redirect(route('events.index'))->with('success', __('constant.CREATED', ['module' => __('constant.EVENT')]));

        }

    }

