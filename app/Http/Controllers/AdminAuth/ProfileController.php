<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function edit(Request $request)
    {
        $admin = Admin::findorfail(Auth::user()->id);
        $title = __('constant.PROFILE');
        return view('admin.profile.index', compact('title', 'admin'));
    }

    public function update(Request $request)
    {
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->storeAs(
                'public/profile', date('Y-m-d') . '__' . guid() . '__' . $request->file('profile')->getClientOriginalName()
            );
        }
        //dd($path);
        $validatedData = $request->validate([
            'old_password'  =>  'nullable|min:6',
            'new_password'  =>  'same:old_password',
        ],['same'=>'The new password and confirm password must match.']);

        $admin = Admin::findorfail(Auth::user()->id);
        if ($request->hasFile('profile')) {
            $admin->profile = $path;
        }
        if($request->new_password)
        {
            $admin->password = Hash::make($request->new_password);
        }
        $admin->save();
        return back()->with('success', __('constant.UPDATED', ['module'    =>  __('constant.PROFILE')]));
    }
}
