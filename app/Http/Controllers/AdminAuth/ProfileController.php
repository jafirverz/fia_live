<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


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
        //dd($path);
        $validatedData = $request->validate([
            'old_password'  =>  'nullable|min:6',
            'new_password'  =>  'same:old_password',
        ],['same'=>'The new password and confirm password must match.']);

        $admin = Admin::findorfail(Auth::user()->id);
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/profile')) {
            mkdir('uploads/profile');
        }
        $destinationPath = 'uploads/profile'; // upload path
        $profile_image = '';
        $profilePath = null;
        if ($request->hasFile('profile')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('profile')->getClientOriginalExtension();
            // Filename to store
            $profile_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('profile')->move($destinationPath, $profile_image);
        }
        if ($request->hasFile('profile')) {
            if ($admin->profile) {
                File::delete($admin->profile);
            }
            $profilePath = $destinationPath . '/' . $profile_image;
            $admin->profile = $profilePath;
        }
        if($request->new_password)
        {
            $admin->password = Hash::make($request->new_password);
        }
        $admin->save();
        return back()->with('success', __('constant.UPDATED', ['module'    =>  __('constant.PROFILE')]));
    }
}
