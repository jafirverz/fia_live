<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserSideMail;
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
        $users = User::where('subscribe_status', 1)->get();

        $weekly = Carbon::now()->add(-7, 'day')->format('Y-m-d');

        $regulatories = Regulatory::where('parent_id', '!=', null)->latest()->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') new_date"), DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d') modified_date"), 'regulatories.*')->get();

        $weeklyRegulatories = $regulatories->where('modified_date', '>=', $weekly);
        //dd($weeklyRegulatories);
        $content = [];
        foreach($weeklyRegulatories as $regulatory)
        {
            $value = getRegulatoryData($regulatory->parent_id);
            $content[] = '<h3>'.$regulatory->title.'</h3><a href="'.url('regulatory-details', $value->slug) . '?id=' . $regulatory->id.'">Read More</a><br/>';
        }

        if ($weeklyRegulatories->count()) {
            $emailTemplate_user = $this->emailTemplate(__('constant.END_DAY_REPORT'));
            if ($emailTemplate_user) {
                foreach ($users as $user) {
                    $content = implode('<hr/>', $content);
                    $data_user = [];
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $data_user['email_sender_name'] = setting()->email_sender_name;
                    $data_user['from_email'] = setting()->from_email;
                    $data_user['subject'] = $emailTemplate_user->subject;
                    $key_user = ['{{name}}', '{{content}}'];
                    $value_user = [$user->firstname . ' ' . $user->lastname, $content];
                    $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                    $data_user['contents'] = $newContents_user;
                    try {
                        $mail_user = Mail::to($user->email)->send(new UserSideMail($data_user));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }
        }
    }
}
