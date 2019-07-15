<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory;
use App\RegulatoryHighlight;

class RegulatoryHighlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'REGULATORY_HIGHLIGHT';
    }

    public function edit()
    {
        $title = __('constant.REGULATORY_HIGHLIGHT');
        $subtitle = 'Highlight';

        $regulatories = Regulatory::where('parent_id', null)->get();
        $regulatory_highlight = RegulatoryHighlight::first();

        return view('admin.regulatory.highlight.edit', compact('title', 'subtitle', 'regulatories', 'regulatory_highlight'));
    }

    public function update(Request $request)
    {
        if(RegulatoryHighlight::count()<1)
        {
            $regulatories = new RegulatoryHighlight;
        }
        else
        {
            $regulatories = RegulatoryHighlight::first();
        }
        $regulatories->main_highlight = $request->main_highlight;
        $regulatories->other_highlight1 = $request->other_highlight1;
        $regulatories->other_highlight2 = $request->other_highlight2;
        $regulatories->other_highlight3 = $request->other_highlight3;
        $regulatories->other_highlight4 = $request->other_highlight4;
        $regulatories->other_highlight5 = $request->other_highlight5;
        $regulatories->save();

        return redirect('admin/regulatory')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.REGULATORY_HIGHLIGHT')]));
    }
}
