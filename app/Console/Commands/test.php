<?php

namespace App\Console\Commands;

use App\AliceSecure;
use App\Jobs\SendEmail;
use App\Jobs\SendTelegramNotify;
use App\Notifications\SensorNotify;
use App\Notifications\UserNotify;
use App\User;
use App\Weather;
use DateInterval;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use phpDocumentor\Reflection\Types\Object_;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'testing new some function';

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
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        /*
        $this->info('test registring user in AliceSecure');
        $id = '13D65C01F8B51512AF66DAC3DCAE2F893A9D3E8B0851A6BF9C44EB512D48F065';

//        $security = new AliceSecure();
//        $security->registerUser($userId);
        $admin = AliceSecure::isAdmin($id);
        print_r($admin);
        */
        /*
        $this->interval = '1 minute';
        $lastRunDate = new DateTime('NOW');
        $this->last_run = $lastRunDate->format('Y-m-d H:i:s');
        if($this->interval !== null && $this->interval !== '') {
            $interval = DateInterval::createFromDateString( $this->interval );
            $nextRunDate = $lastRunDate->add( $interval );
            $this->next_run = $nextRunDate->format('Y-m-d H:i:00');
        }
        $this->info($this->next_run);
        */
/*
        $text = 'lol test queue job';
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
        SendTelegramNotify::dispatch($text);
        SendEmail::dispatch($text);
*/
        $text = 'Критическое влажность в пристройе 10 %';
        $note = new UserNotify($text);
        $user = User::where('name', 'decole')->first();
        $sendEmail = false;
        foreach ($user->unreadNotifications as $notification) {
            if ($notification->type == 'App\Notifications\SensorNotify') {
                $this->info($notification->data['message']);
                if ($notification->data['message'] == $note->data)
                {
                    $startTime = Carbon::parse($notification->created_at);
                    $finishTime = Carbon::now();
                    if ( $finishTime->diffInSeconds($startTime) > 900 ) {
                        $sendEmail = true;
                        $this->info($finishTime->diffInSeconds($startTime));
                    }
                    break;
                }
            }
        }
        if ($sendEmail) {
            $this->info('send notify');
        }
    }

}
