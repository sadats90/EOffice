<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Applicant\Entities\Application;

class ApplicationReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset applications which can not pass within 1 month';

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
        $applications = Application::where('is_cd',0)->where('is_submit',1)->get();
        $today = date('Y-m-d');
        foreach ($applications as $app) {
            if($today >= $app->expired_date ) {
                $reset_app = Application::find($app->id);
                $reset_app->current_stage = 2;
                $reset_app->is_failed = 1;
                $reset_app->is_issue = 0;
                $reset_app->is_letter_issue = 0;
                $reset_app->is_survey = 0;
                $reset_app->is_survyed = 0;
                $reset_app->pv_indate = date('Y-m-d');
                $reset_app->pv_outdate = null;
                $reset_app->pv_verified = 0;
                $reset_app->sv_indate = null;
                $reset_app->sv_outdate = null;
                $reset_app->sv_verified = 0;
                $reset_app->fv_indate = null;
                $reset_app->fv_outdate = null;
                $reset_app->fv_verified = 0;
                $reset_app->survey_indate = null;
                $reset_app->survey_outdate = null;
                $reset_app->letter_issue_indate = null;
                $reset_app->letter_issue_outdate = null;
                $reset_app->is_certificate = 0;
                $reset_app->certificate_indate = null;
                $reset_app->certificate_outdate = null;
                $reset_app->certificate_ready = 0;
                $reset_app->is_cv = 0;
                $reset_app->cv_indate = null;
                $reset_app->cv_outdate = null;
                $reset_app->cv_verified = 0;
                $reset_app->is_cc = 0;
                $reset_app->cc_indate = null;
                $reset_app->cc_outdate = null;
                $reset_app->cc_signed = 0;
                $reset_app->app_in_disburse = 0;
                $reset_app->is_cd = 0;
                $reset_app->cd_indate = null;
                $reset_app->cd_outdate = null;
                $reset_app->expired_date = null;
                $reset_app->save();

            }
        }
    }
}
