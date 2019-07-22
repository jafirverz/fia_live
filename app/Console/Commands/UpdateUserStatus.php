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

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'updateuserstatus:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
    }
}
