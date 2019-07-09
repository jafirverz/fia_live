<?php

namespace App\Http\Controllers\Auth;

use App\Banner;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $slug = __('constant.LOGIN');
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        $banner = Banner::where('page_name', $page->id)->first();
        $breadcrumbs = getBreadcrumb($page);
        return view('auth.login', compact("page", "banner", "breadcrumbs"));
    }

    protected function authenticated(Request $request, $user)
    {
        $error_message = "";
        if($user->status==1)
        {
            $error_message = "Oops! Please verify your email.";
        }
        elseif($user->status==2)
        {
            $error_message = "Oops! Please wait for Admin Approval.";
        }
        else if($user->status==3)
        {
            $error_message = "Sorry! Your application has been rejected. Please contact admin.";
        }
        else if($user->status==4)
        {
            $error_message = "Oops! Please complete your pending payment or contact admin.";
        }
        else if($user->status==6)
        {
            $error_message = "Sorry! Your account is currenly inactive. Please contact admin.";
        }
        else if($user->status==7)
        {
            $error_message = "Sorry! Your account has been lapsed. Please contact admin.";
        }
        else if($user->status==8)
        {
            $error_message = "Sorry! Your account has been expired. Please contact admin.";
        }
        if($error_message)
        {
            Auth::logout();
        }
        return redirect()->intended('login')->with('error', $error_message);
    }
}
