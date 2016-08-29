<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\MeetupApiHelper;
use App\SlackInvite;
use Carbon\Carbon;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {
            $helper = new MeetupApiHelper();
            $helper->checkMeetupForUpdates();
        })->everyTenMinutes();

        $schedule->call(function () {
            $deleteMin = config('slack.invite_request.invite_delete_minutes');
            if (!$deleteMin) {
                return false;
            }
            $cutoff = Carbon::now()->subMinutes($deleteMin);
            $deletes = SlackInvite::where('created_at', '>', $cutoff)->delete();
            if ($deletes) {
                Log::info('Removed '.$deletes.' rows from slack_invites table');
            }
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
