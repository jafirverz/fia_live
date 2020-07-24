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

    //You can test by url follow route below
    //Route::get('/user/weekly-report', 'CMS\UserController@weeklyReport')->name('weekly-report');
    public function handle()
    {
        //DB::enableQueryLog();
        $users = User::where('subscribe_status', 1)->get();
        $today_date = Carbon::now();
        $beforeWeek = Carbon::now()->addDay(-7);
        $beforeMonth = Carbon::now()->subMonth();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $weekly = $beforeWeek->format('Y-m-d');
        $startOfMonthDate = $startOfMonth->format('Y-m-d');
        $endOfMonthDate = $endOfMonth->format('Y-m-d');
        $today_date = Carbon::now();
        $weeklyRegulatories = Regulatory::where('parent_id', '!=', null)->whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();

        $weeklyTopicalReports = TopicalReport::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();

        //Podcast update we will send for whole month repeat in every week.
        $weeklyPodcasts = Podcast::whereDate('created_at', '>=', $startOfMonthDate)->whereDate('created_at', '<=', $endOfMonthDate)->latest()->limit(10)->get();

        $weeklyThinkingPiece = ThinkingPiece::whereDate('created_at', '>=', $weekly)->whereDate('created_at', '<=', $today_date)->latest()->limit(10)->get();
        //dd(DB::getQueryLog());
        $content = [];
        if ($weeklyPodcasts->count()) {
            $i = 0;
            $len = $weeklyPodcasts->count();
            $content[] = '<tr><td>';
            foreach ($weeklyPodcasts->sortByDesc('created_at') as $podcast) {

                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Podcast</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
														<tbody> 
															<tr>
																<td style="padding-top:5px;"><img src="' . asset($podcast->thumb_image) . '" alt="" width="120px" /></td>
																<td style="padding-top:5px;"><img src="' . asset('images/tempt/blank.png') . '" alt="" style="width:30px" /></td>
																<td style="padding-top:5px;">
                                                                <p style="color: #017cba;font-family: Arial !important;padding-top:10px; "><b>' . date('M Y', strtotime($podcast->created_at)) . ' | </b>' . strtoupper($podcast->title) . '</p>
                                                                <p style="color: #000000;font-family: Arial !important;padding-top:10px; ">';
                if (strlen($podcast->description) > 50) {
                    $content[] = substr($podcast->description, 0, 50) . '...';
                } else {
                    $content[] =  $podcast->description;
                }
                $content[] = '</p>
                                                                <p style="text-align:right"><a href="' . url('podcast') . '?id=' . $podcast->id . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Listen Now</b></a></p>
																</td>
															</tr> 
														</tbody>
													</table> 
                                    
                                    </td>
                                </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }
        if ($weeklyRegulatories->count()) {
            $content[] = '<tr><td>';
            $i = 0;
            $len = $weeklyRegulatories->count();
            foreach ($weeklyRegulatories->sortByDesc('regulatory_date') as $regulatory) {
                $value = getRegulatoryData($regulatory->parent_id);
                if ($value) {
                    if ($i == 0) {
                        $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                        $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Regulatory Issues</p>
                                                </td>
                                            </tr>';
                    }
                    $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important;"><b>' . date('d M Y', strtotime($regulatory->regulatory_date)) . ' | </b>' . strtoupper($regulatory->title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('regulatory-details', $value->slug) . '?id=' . $regulatory->id . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                    if ($i == ($len - 1)) {
                        $content[] = '</tbody>
                        </table>';
                    }
                }
                $i++;
            }
            $content[] = '</td></tr>';
        }

        if ($weeklyTopicalReports->count()) {
            $i = 0;
            $len = $weeklyTopicalReports->count();
            $content[] = '<tr><td>';
            foreach ($weeklyTopicalReports->sortByDesc('regulatory_date') as $topical) {

                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Topical Reports</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important;"><b>' . date('d M Y', strtotime($topical->created_at)) . ' | </b>' . strtoupper($topical->title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('topical-reports') . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }



        if ($weeklyThinkingPiece->count()) {
            $i = 0;
            $len = $weeklyThinkingPiece->count();
            $content[] = '<tr><td>';
            foreach ($weeklyThinkingPiece->sortByDesc('created_at') as $thinking) {
                $thinking_piece_title = str_replace(" ", "-", $thinking->thinking_piece_title);
                if ($i == 0) {
                    $content[] = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                        <tbody>';
                    $content[] = '<tr>
                                                <td style="border-bottom: #ddd solid 1px; text-align: left; padding: 10px 30px; font-size: 16px;">
                                                    <p style="color: #f48120;font-family: Arial !important; font-size: 20px; font-weight: bold; margin: 0; ">Thinking Piece</p>
                                                </td>
                                            </tr>';
                }
                $content[] = '<tr>
                                    <td style="text-align: left; padding: 10px 30px 0; font-size: 16px;">
                                    <p style="color: #017cba;font-family: Arial !important; "><b>' . date('d M Y', strtotime($thinking->created_at)) . ' | </b>' . strtoupper($thinking->thinking_piece_title) . '</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="text-align: right; padding: 10px 30px 0; font-size: 16px;">
                                <a href="' . url('thinking-piece/' . strtolower($thinking_piece_title)) . '" target="_blank" style="font-family: Arial !important;color: #f48120; text-decoration:none; "> <b>Read More</b></a>
                                </td>
                            </tr>';
                if ($i == ($len - 1)) {
                    $content[] = '</tbody>
                        </table>';
                }

                $i++;
            }
            $content[] = '</td></tr>';
        }


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
                        //user mail test
                        $mail_user = Mail::to($user->email)->queue(new RegulatoryUpdates($data_user));
                    } catch (Exception $exception) {
                    }
                }
            }
        }
    }
}
