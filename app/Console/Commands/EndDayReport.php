<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegulatoryUpdates;
use Carbon\Carbon;
use App\User;
use App\Regulatory;
use App\TopicalReport;
use App\ThinkingPiece;
use App\Podcast;
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
        $today_date = Carbon::now();
        $beforeWeek = Carbon::now()->addDay(-7);
        $weekly = $beforeWeek->format('Y-m-d');
        $today_date = Carbon::now();

        $weeklyRegulatories = Regulatory::where('parent_id', '!=', null)->whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
		
		$weeklyTopicalReports = TopicalReport::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
		
		$weeklyPodcasts = Podcast::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
        
		$weeklyThinkingPiece = ThinkingPiece::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
		//dd(DB::getQueryLog());
        // dd($weeklyRegulatories->count());
        $content = [];
		$content [] = '<table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
       style="box-sizing: border-box; background-color: #f8fafc; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center"
            style="box-sizing: border-box;">
            <table class="content inner-body" width="100%" cellpadding="0" cellspacing="0"
                   style="box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                <tr>
                    <td style="box-sizing: border-box; line-height: 0 !important; text-align: center; padding: 10px;">
                        <a href="http://fia.verz1.com" target="_blank"
                           style="box-sizing: border-box; color: #3869d4;">
                            <img style=" box-sizing: border-box; max-width: 100%; border: none; width: 120px;"
                                 src="http://fia.verz1.com/uploads/systemSettings/Logo_RGB_1568843307_1569902107.png">
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="570px" align="center" cellpadding="0" cellspacing="0"
                        style="box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                        <table style="margin: 0 auto; padding: 0; max-width: 600px; width: 100%; text-align: center; color: #000;">
                            <tbody>
                            <tr>
                                <td style="padding: 30px 0px 30px 0px;">
                                    <img src="images/banner.png" alt="" width="100%" height="153" />
                                </td>
                            </tr>';
        if($weeklyRegulatories->count())
        {
            $content [] = '<tr><td>';
			$i = 0;
            $len = $weeklyRegulatories->count();
            foreach ($weeklyRegulatories->sortByDesc('regulatory_date') as $regulatory) {
                $value = getRegulatoryData($regulatory->parent_id);
                if ($value) {
                    if($i==0)
                    {
                        $content [] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
						$content [] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Regulatory</p>
                                                </td>
                                            </tr>';
                    }
                    $content [] = '<tr>
                                    <td style="text-align: left; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($regulatory->regulatory_date)) . ' | </b>' . $regulatory->title . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                <a href="' . url('regulatory-details', $value->slug) . '?id=' . $regulatory->id . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if($i==($len-1))
                    {
                        $content[] = '</tbody>
                        </table>';
                    }
                }
                $i++;
            }
			$content [] = '</td></tr>';
           
        }
		
		if($weeklyTopicalReports->count())
        {
            $i = 0;
            $len = $weeklyTopicalReports->count();
			 $content [] = '<tr><td>';
            foreach ($weeklyTopicalReports->sortByDesc('regulatory_date') as $topical) {
                
                    if($i==0)
                    {
                        $content [] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
						$content [] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Topical Reports</p>
                                                </td>
                                            </tr>';
                    }
                    $content [] = '<tr>
                                    <td style="text-align: left; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($topical->created_at)) . ' | </b>' . $topical->title . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                <a href="' . url('topical-reports') .'" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if($i==($len-1))
                    {
                        $content[] = '</tbody>
                        </table>';
                    }
               
                $i++;
            }
			$content [] = '</td></tr>';
            
        }
		
		if($weeklyPodcasts->count())
        {
            $i = 0;
            $len = $weeklyPodcasts->count();
			 $content [] = '<tr><td>';
            foreach ($weeklyPodcasts->sortByDesc('created_at') as $podcast) {
                
                    if($i==0)
                    {
                        $content [] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
						$content [] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Podcast</p>
                                                </td>
                                            </tr>';
                    }
                    $content [] = '<tr>
                                    <td style="text-align: left; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($podcast->created_at)) . ' | </b>' . $podcast->title . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                <a href="' . url('podcast') .'" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if($i==($len-1))
                    {
                        $content[] = '</tbody>
                        </table>';
                    }
               
                $i++;
            }
			$content [] = '</td></tr>';
            
        }
		
		if($weeklyThinkingPiece->count())
        {
            $i = 0;
            $len = $weeklyThinkingPiece->count();
			$content [] = '<tr><td>';
            foreach ($weeklyThinkingPiece->sortByDesc('created_at') as $thinking) {
                $thinking_piece_title=str_replace(" ","-",$thinking->thinking_piece_title);
                    if($i==0)
                    {
                        $content [] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
						$content [] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Thinking Piece</p>
                                                </td>
                                            </tr>';
                    }
                    $content [] = '<tr>
                                    <td style="text-align: left; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($thinking->created_at)) . ' | </b>' . $thinking->title . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 0 30px 0; font-size: 16px;padding-bottom: 10px;">
                                <a href="' . url('thinking-piece/'.strtolower($thinking_piece_title)) .'" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if($i==($len-1))
                    {
                        $content[] = '</tbody>
                        </table>';
                    }
               
                $i++;
            }
            $content [] = '</td></tr>';
            
        }
		$content [] =' <tr>
                                <td style="position: relative; z-index: 1; padding: 20px 0;">
                                    <a href="mailto:regulatory@foodindustry.asia" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" src="http://fia.verz1.com/photos/2/icon6.jpg"></a> &nbsp;&nbsp;&nbsp; <a href="https://www.linkedin.com/company/food-industry-asia/" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="http://fia.verz1.com/photos/2/icon5.jpg"></a> &nbsp;&nbsp;&nbsp; <a href="https://twitter.com/foodindasia" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="http://fia.verz1.com/photos/2/icon2.jpg"></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="box-sizing: border-box;">
                                    <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                        <tbody>
                                            <tr>
                                                <td class="content-cell" align="center" style="box-sizing: border-box; padding: 0 15px 25px; text-align: center;">
                                                    <p style="font-size: 9px; font-family: Arial !important;">Copyright &copy; 2019 Food Industry Asia (FIA), All rights reserved.</p>
                                                    <p style="font-size: 9px; font-family: Arial !important;">You may <a style="color:#999;font-family: Arial !important;" href="http://fia.verz1.com/unsubscribe?id=bmlrdW5qQHZlcnpkZXNpZ24uY29t" target="_blank">unsubscribe</a> from this email if you no longer wish to receive FIA Weekly Regulatory Updates.</p>
                                                    <p style="font-size: 9px; font-family: Arial !important;">The Regulatory Updates should not be distributed without the prior permission of FIA.</p>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

		if ($content) {
                $emailTemplate_user = $this->emailTemplate(__('constant.END_DAY_REPORT'));
                if ($emailTemplate_user) {
                    $content_data = implode(' ', $content);
                    $email_template_logo = '<img  src="' . asset(setting()->email_template_logo) . '" alt="">';
                    $contact = '<a href="mailto:regulatory@foodindustry.asia" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" src="' . asset('photos/2/icon6.jpg') . '"></a>';
                    $linkedin = '<a href="' . setting()->linkedin_link . '" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="' . asset('photos/2/icon5.jpg') . '"></a>';
                    $twitter = '<a href="' . setting()->twitter_link . '" target="_blank" style="width: 20px;display: inline-block;margin: 0 5px;"><img width="20px" height="20px" src="' . asset('photos/2/icon2.jpg') . '"></a>';
                    foreach ($users as $user) {

                        $data_user = [];
                        $data_user['subject'] = $emailTemplate_user->subject;
                        $data_user['email_sender_name'] = setting()->email_sender_name;
                        $data_user['from_email'] = setting()->from_email;
                        $unsubscribe = '<a style="color:#999;font-family: Arial !important;" href="' . url('unsubscribe?id=' . base64_encode($user->email)) . '" target="_blank">unsubscribe</a>';
                        $data_user['subject'] = $emailTemplate_user->subject;
                        $key_user = ['{{logo}}', '{{contact}}', '{{linkedin}}', '{{twitter}}', '{{content}}', '{{unsubscribe}}'];
                        $value_user = [$email_template_logo, $contact, $linkedin, $twitter, $content_data, $unsubscribe];
                        $newContents_user = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
                        $data_user['contents'] = $newContents_user;
                        try {
                            $mail_user = Mail::to($user->email)->queue(new RegulatoryUpdates($data_user));
                        } catch (Exception $exception) {

                        }
                    }
                }
            }
    }
}
