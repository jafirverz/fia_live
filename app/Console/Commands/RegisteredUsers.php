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

class RegisteredUsers extends Command
{
    use GetEmailTemplate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to active user';

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
        $users = User::whereNotNull('expired_at')
            ->where('status', __('constant.ACCOUNT_ACTIVE'))
            ->select(DB::raw('DATE(expired_at) as date'), 'expired_at', 'status', 'firstname', 'lastname', 'email')
            ->get();
        $oneMonthAfter = Carbon::now()->add(-1, 'day')->add(1, 'month')->format('Y-m-d');
        $oneWeekAfter = Carbon::now()->add(-1, 'day')->add(7, 'day')->format('Y-m-d');


        $oneMonthReminders = $users->where('date', $oneMonthAfter);
        $oneWeekReminders = $users->where('date', $oneWeekAfter);
        if ($oneMonthReminders->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($oneMonthReminders as $user) {
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
        if ($oneWeekReminders->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.REMINDER_EMAIL_TEMP_ID'));

            foreach ($oneWeekReminders as $user) {
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
