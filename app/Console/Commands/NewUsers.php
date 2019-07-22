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
        $users = User::whereDate('expired_at', '<', date('Y-m-d'))->where('status', [__('constant.ACCOUNT_ACTIVE')])->get();
        $newUsers = User::whereDate('renew_at', '<', Carbon::now()->add(-3, 'month')->format('Y-m-d'))->where('renew_status', 0)->where('status', __('constant.PENDING_FOR_PAYMENT'))->get();
        if ($users->count()) {
            foreach ($users as $user) {
                $user->status = __('constant.ACCOUNT_EXPIRED');
                $user->renew_status = 3;
                $user->renew_at = Carbon::now()->toDateTimeString();
                $user->save();
            }
        }

        if ($newUsers->count()) {
            foreach ($newUsers as $user) {
                $user->status = __('constant.ACCOUNT_LAPSED');
                $user->renew_status = 0;
                $user->renew_at = Carbon::now()->toDateTimeString();
                $user->save();
            }
        }
    }
}
