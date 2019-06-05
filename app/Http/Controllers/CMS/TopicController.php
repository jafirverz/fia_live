<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topic;
use Carbon\Carbon;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'TOPIC';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('constant.TOPIC');
        $subtitle = 'Index';
        $topics = Topic::all();

        return view('admin.regulatory.topics.index', compact('title', 'subtitle', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('constant.TOPIC');
        $subtitle = 'Create';

        return view('admin.regulatory.topics.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_name'  =>  'required|unique:topics,topic_name',
        ]);

        $topic = new Topic();
        $topic->topic_name = $request->topic_name;
        $topic->save();

        return redirect('admin/topic')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.TOPIC')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('constant.TOPIC');
        $subtitle = 'Edit';
        $topic = Topic::findorfail($id);

        return view('admin.regulatory.topics.edit', compact('title', 'subtitle', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'topic_name'  =>  'required|unique:topics,topic_name,'.$id.',id',
        ]);

        $topic = Topic::findorfail($id);
        $topic->topic_name = $request->topic_name;
        $topic->updated_at = Carbon::now();
        $topic->save();

        return redirect('admin/topic')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.TOPIC')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $topic = Topic::findorfail($request->id);
        $topic->delete();

        return redirect('admin/topic')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.TOPIC')]));
    }
}
