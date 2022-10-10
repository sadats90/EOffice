<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email backup database';

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
        $mail_data = array(
            'subject'   =>  'Database Backup',
            'email'     =>  'jakir.ruet.bd@gmail.com'
        );

        Mail::send('email_templates.backup-database',[], function ($message) use($mail_data) {
            $message->to($mail_data['email']);
            $message->subject($mail_data['subject']);
            $message->attach(base_path('database/dump.sql'));
        });

    }
}
