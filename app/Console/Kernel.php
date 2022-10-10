<?php

namespace App\Console;

use App\Console\Commands\ApplicationReset;
use App\Console\Commands\BackupDatabase;
use App\Console\Commands\EmailDatabase;
use App\Http\Helpers\Message;
use App\Models\Task;
use App\Models\WorkHandover;
use App\Models\WorkingPermission;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BackupDatabase::class,
        EmailDatabase::class,
        ApplicationReset::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Daily Reset Application
        $schedule->command('application:reset')
            ->daily()
            ->timezone('Asia/Dhaka');

        //Daily Backup Database
        $schedule->command('backup:database')
            ->daily()
            ->timezone('Asia/Dhaka');

        //Daily Sent Database to email
        $schedule->command('email:database')
            ->dailyAt('00:05')
            ->timezone('Asia/Dhaka');

        //Cancel work handover
        $schedule->call(function (){
            $workHandovers = WorkHandover::where([['end_date', '<', date('y-m-d')]])->get();
            if(count($workHandovers) > 0){
                foreach ($workHandovers as $handover){
                    $user = User::where([['id', $handover->from_user_id], ['is_active', 1], ['is_work_handover', 1]])->first();

                    $task_id = Task::where('key', "WH")->first()->id;

                    $anyHandoversAvailable = WorkHandover::where([['user_id', $handover->user_id], ['from_user_id', $handover->from_user_id]])->get();
                    if(count($anyHandoversAvailable) == 0){
                        $taskPermission = WorkingPermission::where([['user_id', $handover->user_id], ['task_id', $task_id]])->first();
                        if($taskPermission != null)
                            $taskPermission->delete();
                    }

                    $user->is_work_handover = 0;
                    $user->save();
                }
            }
        })->dailyAt('00:01')->timezone('Asia/Dhaka');

        //Sent Daily Sms
        $schedule->call(function (){
            Message::SendSMS('01790190009','Hi, This is scheduler testing sms from RDA.');
        })->everyMinute();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
