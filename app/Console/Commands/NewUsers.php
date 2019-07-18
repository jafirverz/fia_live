<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use App\Mail\UserSideMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;

class NewUsers extends Command
{
    use GetEmailTemplate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('renew_status', 0)
            ->where('status', __('constant.PENDING_FOR_PAYMENT'))
            ->select(DB::raw('DATE(created_at) as date'), 'renew_status', 'status', 'firstname', 'lastname', 'email')
            ->get();
        $before30Day = Carbon::now()->add(-30, 'day')->format('Y-m-d');
        $before60Day = Carbon::now()->add(-60, 'day')->format('Y-m-d');
        $before75Day = Carbon::now()->add(-75, 'day')->format('Y-m-d');
        $before3month = Carbon::now()->add(-1, 'day')->add(-3, 'month')->format('Y-m-d');

        $thirtyDayUsers = $users->where('date', $before30Day);
        $sixtyDayUsers = $users->where('date', $before60Day);
        $seventyFiveDayUsers = $users->where('date', $before75Day);
        $threeMonthUsers = $users->where('date', $before3month);
        //dd($thirtyDayUsers,$sixtyDayUsers,$seventyFiveDayUsers,$threeMonthUsers);
        if ($thirtyDayUsers->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($thirtyDayUsers as $user) {
                if ($emailTemplate_user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{firstname}}'];
                    $value_user = [$user->firstname];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }


            }
        }
        if ($sixtyDayUsers->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($sixtyDayUsers as $user) {
                if ($emailTemplate_user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{firstname}}'];
                    $value_user = [$user->firstname];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }


            }
        }
        if ($threeMonthUsers->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($threeMonthUsers as $user) {
                if ($emailTemplate_user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{firstname}}'];
                    $value_user = [$user->firstname];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }
            }
        }
        if ($seventyFiveDayUsers->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($seventyFiveDayUsers as $user) {
                if ($emailTemplate_user) {

                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{firstname}}'];
                    $value_user = [$user->firstname];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }
            }
        }
    }
}
