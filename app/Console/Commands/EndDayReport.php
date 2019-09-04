<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegulatoryUpdates;
use Carbon\Carbon;
use App\User;
use App\Regulatory;
use DB;
use Illuminate\Support\Str;

class EndDayReport extends Command
{
    use GetEmailTemplate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enddayreport:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End Day Report';

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
        //DB::enableQueryLog();
        $users = User::where('subscribe_status', 1)->get();

        $beforeWeek = Carbon::now()->add(-7, 'day');
        $weekly = $beforeWeek->format('Y-m-d');
        $today_date = Carbon::now();

        $weeklyRegulatories = Regulatory::where('parent_id', '!=', null)->whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
        //dd(DB::getQueryLog());
        //dd($weeklyRegulatories->count());
        $content = [];
        foreach($weeklyRegulatories as $regulatory)
        {
            $value = getRegulatoryData($regulatory->parent_id);
            if($value)
            {
                $content[] = '<tr><td style="text-align: left; padding: 0 30px 0; font-size: 12px;"><p style="color: #f48120; ">'.$regulatory->title.'</p><p>'.Str::limit($regulatory->description, 300).'<a href="'.url('regulatory-details', $value->slug) . '?id=' . $regulatory->id.'" target="_blank" style="color: #f48120; text-decoration:none; "> Read more </a></p></td></tr>';
            }
        }

        if ($content) {
            $emailTemplate_user = $this->emailTemplate(__('constant.END_DAY_REPORT'));
            if ($emailTemplate_user) {
                $content_data = implode(' ', $content);
                $email_template_logo = '<img src="'.asset(setting()->email_template_logo).'" alt="">';
                $linkedin = '<a href="'.setting()->linkedin_link.'" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img src="'.asset('images/icon5.jpg').'"></a>';
                $twitter = '<a href="'.setting()->twitter_link.'" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img src="'.asset('images/icon2.jpg').'"></a>';
                foreach ($users as $user) {
                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{logo}}', '{{linkedin}}', '{{twitter}}', '{{content}}'];
                    $value_user = [$email_template_logo, $linkedin, $twitter, $content_data];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->queue(new RegulatoryUpdates($data_user));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }
            }
        }
    }
}
