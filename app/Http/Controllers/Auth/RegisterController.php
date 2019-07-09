<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Banner;
use App\Page;
use App\Mail\UserSideMail;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $slug = __('constant.REGISTER');
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->first();
        $banner = Banner::where('page_name', $page->id)->first();
        $breadcrumbs = getBreadcrumb($page);
        return view('auth.register', compact("page", "banner", "breadcrumbs"));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'organization' => 'required|alpha_num',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $student_id = guid();
        return User::create([
            'student_id'    =>  $student_id,
            'salutation' => $data['salutation'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'organization' => $data['organization'],
            'job_title' => $data['job_title'],
            'telephone_code' => $data['telephone_code'],
            'telephone_number' => $data['telephone_number'],
            'mobile_code' => $data['mobile_code'],
            'mobile_number' => $data['mobile_number'],
            'country' => $data['country'],
            'city' => $data['city'],
            'address1' => $data['address1'],
            'address2' => $data['address2'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'subscribe_status'  => $data['subscribe_status'] ?? null,
            'status'    =>  1,
        ]);

        $student = [
            'button_url' => url('/register/verification/' . $student_id),
            'student_name' => $data['firstname'] . ' ' . $data['lastname'],
        ];
        $emailTemplate = $this->emailTemplate(__('constant.STUDENT_VERIFICATION'));

        if ($emailTemplate) {

            $data['subject'] = $emailTemplate->subject;
            $data['email_sender_name'] = setting()->email_sender_name;
            $data['from_email'] = setting()->from_email;
            $data['subject'] = $emailTemplate->subject;
            $key = ['{{name}}', '{{button_url}}'];
            $value = [$student['student_name'], $student['button_url']];
            $newContents = replaceStrByValue($key, $value, $emailTemplate->contents);
            $data['contents'] = $newContents;
            //dd($data);

            try {
                if ($data['email']) {
                    $mail_user = Mail::to($data['email'])->send(new UserSideMail($data));
                }

            } catch (Exception $exception) {
                return dd($exception);

            }
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->with('success', 'An email is sent to your mail box with a link, please click on the link for verification. If you did not receive the email, please check your SPAM folder.');
    }
}
