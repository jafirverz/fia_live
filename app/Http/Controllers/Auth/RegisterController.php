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
use App\Mail\AdminSideMail;
use App\Traits\GetEmailTemplate;
use App\Traits\DynamicRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use DynamicRoute;
    use GetEmailTemplate;
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'organization' => 'required|string',
            'country'   =>  'required',
            'email' => 'required|email|unique:users,email,6,status',
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

        $user_id = guid();
        $user_data = User::where('email', $data['email'])->where('status', 6)->first();
        if($user_data)
        {
            $user_data->user_id   =  $user_id;
            $user_data->salutation = $data['salutation'];
            $user_data->firstname = $data['firstname'];
            $user_data->lastname = $data['lastname'];
            $user_data->organization = $data['organization'];
            $user_data->job_title = $data['job_title'];
            $user_data->telephone_code = $data['telephone_code'];
            $user_data->telephone_number = $data['telephone_number'];
            $user_data->mobile_code = $data['mobile_code'];
            $user_data->mobile_number = $data['mobile_number'];
            $user_data->country = $data['country'];
            $user_data->city = $data['city'];
            $user_data->address1 = $data['address1'];
            $user_data->address2 = $data['address2'];
            $user_data->password = Hash::make($data['password']);
            $user_data->member_type   =  2;
            $user_data->status    =  1;
            $user_data->save();
        }
        else
        {

            $user_data =  User::create([
                'user_id'    =>  $user_id,
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
                'member_type'   =>  2,
                'subscribe_status'  => $data['subscribe_status'] ?? null,
                'status'    =>  1,
            ]);
        }

        $student = [
            'button_url' => '<a href=' . url('/register/verification/' . $user_id) . ' style="border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
            color: #fff;
            display: inline-block;
            text-decoration: none;
            -webkit-text-size-adjust: none;background-color: #3490dc;
            border-top: 10px solid #3490dc;
            border-right: 18px solid #3490dc;
            border-bottom: 10px solid #3490dc;
            border-left: 18px solid #3490dc;">Verify Email</a>',
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


        //dd($emailTemplate);
        return $user_data;
    }

    public function register(Request $request)
    {
        //dd($request->all());
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->with('success', 'An email is sent to your mail box with a link, please click on the link for verification. If you did not receive the email, please check your SPAM folder.');
    }

    public function verification($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        if($user->email_verified_at)
        {
            return redirect(url('account-verified'));
        }
        $user->email_verified_at = now();
        $user->status = 2;
        $user->save();
        $emailTemplate = $this->emailTemplate(__('constant.USER_REGISTER_ON_SITE'));

        if ($emailTemplate) {

            $data = [];
            $data['subject'] = $emailTemplate->subject;
            $data['email_sender_name'] = setting()->email_sender_name;
            $data['from_email'] = setting()->from_email;
            $data['subject'] = $emailTemplate->subject;
            $key = ['{{name}}', '{{user_id}}'];
            $value = [$user->firstname . ' ' . $user->lastname, $user->user_id];
            $newContents = replaceStrByValue($key, $value, $emailTemplate->contents);
            $data['contents'] = $newContents;

            try {
                if (setting()->from_email) {
                    $mail = Mail::to(setting()->to_email)->send(new AdminSideMail($data));
                }

            } catch (Exception $exception) {
                return dd($exception);

            }
        }
        return redirect(url('verified-thank-you'));
    }
}
