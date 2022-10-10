<?php
Route::prefix('user')->middleware(['auth'])->group(function () {

    //New Application Routes ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('new-application')->middleware('can:isInTask, "admin:na"')->group(function () {

        Route::get('', [
            'as'=>'newApplication',
            'uses'=>'User\NewApplicationController@index'
        ]);
        Route::post('/forward/report-initiate/{id}/{type?}', [
            'as'=>'application/forward/reportInitiate',
            'uses'=>'User\ForwardController@reportInitiate'
        ]);
        Route::get('/forward/delete-map/{id}/{app_id}/{type}', [
            'as'=>'application/forward/deletemap',
            'uses'=>'User\ForwardController@DeleteMap'
        ]);

        Route::get('/forward/delete-plan/{id}/{app_id}/{type}', [
            'as'=>'application/forward/deletePlan',
            'uses'=>'User\ForwardController@DeletePlan'
        ]);
    });


    Route::prefix('application')->middleware('can:isInTask, "admin:fw"')->group(function () {

        //forwarded Application Routes :::::::::::::::::::::::::::::::::::::::::::::::::::::::
        Route::get('', [
            'as'=>'Application',
            'uses'=>'User\ApplicationController@index'
        ]);

        Route::get('/back', [
            'as'=>'BackApplication',
            'uses'=>'User\ApplicationController@back'
        ]);

        Route::get('/wait', [
            'as'=>'WaitApplication',
            'uses'=>'User\ApplicationController@Wait'
        ]);

        Route::get('/view-application/{id}/{type?}', [
            'as'=>'application/view',
            'uses'=>'User\ApplicationController@view'
        ]);

        Route::get('/view-paper/{id}/{type?}', [
            'as'=>'application/viewPaper',
            'uses'=>'User\ApplicationController@viewPaper'
        ]);

        Route::get('/report/{id}/{type}', [
            'as'=>'application/report',
            'uses'=>'User\ApplicationController@report'
        ]);

        Route::get('/forward/{id}/{type?}', [
            'as'=>'application/forward',
            'uses'=>'User\ForwardController@index'
        ]);

        Route::post('/forward/{id}/{type?}', [
            'as'=>'application/forward/Create',
            'uses'=>'User\ForwardController@store'
        ]);
        Route::get('/attachment/add/{id}', [
            'as'=>'attachment/add',
            'uses'=>'User\ForwardController@attachment'
        ]);
        Route::post('/attachment/store/{id}', [
            'as'=>'attachment/store',
            'uses'=>'User\ForwardController@attachmentStore'
        ]);

        Route::post('/attachment/delete/{id}/{app_id}', [
            'as'=>'attachment/Delete',
            'uses'=>'User\ForwardController@attachmentDelete'
        ]);

        Route::get('/invoice/verify/{id}/{type}', [
            'as'=>'invoice/verify',
            'uses'=>'User\ForwardController@invoiceVerify'
        ]);

        Route::post('/forward-cancel/{id}', [
            'as'=>'Application/ForwardCancel',
            'uses'=>'User\ForwardController@cancelApplication'
        ]);

    });


    //letter Issue route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('letter')->group(function () {

        Route::get('/list/{id}/{type?}', [
            'as'=>'letter',
            'uses'=>'User\LetterController@index'
        ])->middleware('can:isInTask, "admin:lp:li"');

        Route::get('/create/{id}/{type}/{hit}', [
            'as'=>'letter/Create',
            'uses'=>'User\LetterController@create'
        ])->middleware('can:isInTask, "admin:lp"');

        Route::post('/create/{id}/{type}/{hit}', [
            'as'=>'letter/store',
            'uses'=>'User\LetterController@store'
        ])->middleware('can:isInTask, "admin:lp"');

        Route::get('/edit/{id}/{app_id}/{type}/{hit}', [
            'as'=>'letter/edit',
            'uses'=>'User\LetterController@edit'
        ])->middleware('can:isInTask, "admin:lp:li"');

        Route::post('/edit/{id}/{app_id}/{type}/{hit}', [
            'as'=>'letter/update',
            'uses'=>'User\LetterController@update'
        ])->middleware('can:isInTask, "admin:lp:li"');

        Route::get('/view/{id}/{app_id}', [
            'as'=>'letter/show',
            'uses'=>'User\LetterController@show'
        ])->middleware('can:isInTask, "admin:lp:li"');

        Route::get('/delete/{id}/{app_id}/{type}/{hit}', [
            'as'=>'letter/delete',
            'uses'=>'User\LetterController@delete'
        ])->middleware('can:isInTask, "admin:lp"');

        Route::get('/sent/{id}/{app_id}/{type}/{hit}', [
            'as'=>'letter/sent',
            'uses'=>'User\LetterController@sent'
        ])->middleware('can:isInTask, "admin:li"');

        Route::get('/view/{id}', [
            'as'=>'letter/solveReview',
            'uses'=>'User\LetterController@solveReview'
        ])->middleware('can:isInTask, "admin:lp:li"');

        Route::get('/invoice/verify/{id}', [
            'as'=>'letter/invoice/verify',
            'uses'=>'User\LetterController@invoiceVerify'
        ]);

        Route::post('/forward-cancel/{id}', [
            'as'=>'letter/ForwardCancel',
            'uses'=>'User\LetterController@cancelApplication'
        ]);
    });

    //Certificate Issue route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('certificate')->group(function () {

        Route::post('/{id}/{type?}', [
            'as'=>'certificate',
            'uses'=>'User\CertificateController@store'
        ])->middleware('can:isInTask, "admin:cm:cv"');

        Route::get('/reset/{id}/{type?}', [
            'as'=>'certificate/reset',
            'uses'=>'User\CertificateController@reset'
        ])->middleware('can:isInTask, "admin:cm:cv"');

        Route::get('/view/{id}/{type?}', [
            'as'=>'certificate/view',
            'uses'=>'User\CertificateController@view'
        ])->middleware('can:isInTask, "admin:cm:cv:cs:cd"');

        Route::get('/issue/{id}/{type?}', [
            'as'=>'certificate/issue',
            'uses'=>'User\CertificateController@issue'
        ])->middleware('can:isInTask, "admin:cv"');

        Route::get('/complete/{id}/{type?}', [
            'as'=>'certificate/complete',
            'uses'=>'User\CertificateController@complete'
        ])->middleware('can:isInTask, "admin:cd"');

    });

    //Certificate Issue route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('certificate-duplicate')->group(function () {

        Route::get('', [
            'as'=>'CertificateDuplicateCopy',
            'uses'=>'User\CertificateDuplicateController@index'
        ])->middleware('can:isInTask, "admin:dc"');

        Route::get('/view/{id}', [
            'as'=>'CertificateDuplicateCopy/view',
            'uses'=>'User\CertificateDuplicateController@view'
        ])->middleware('can:isInTask, "admin:dc"');

    });

    //Complete application route :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('complete')->group(function () {

        Route::get('', [
            'as'=>'complete',
            'uses'=>'User\CompleteApplicationController@index'
        ])->middleware('can:isInTask, "admin"');

        Route::get('/application-view/{id}/{type?}', [
            'as'=>'complete/app_view',
            'uses'=>'User\CompleteApplicationController@applicationView'
        ]);

        Route::get('/paper-view/{id}/{type?}', [
            'as'=>'complete/paper_view',
            'uses'=>'User\CompleteApplicationController@paperView'
        ]);

        Route::get('/report-view/{id}/{type?}', [
            'as'=>'complete/report_view',
            'uses'=>'User\CompleteApplicationController@reportView'
        ]);

        Route::get('/letters/{id}/{type?}', [
            'as'=>'complete/letters',
            'uses'=>'User\CompleteApplicationController@letters'
        ]);

        Route::get('/certificate/{id}/{type?}', [
            'as'=>'complete/certificate',
            'uses'=>'User\CompleteApplicationController@certificate'
        ]);

    });

    //Complete application route :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('swarak-replacement')->group(function () {

        Route::get('/requests', [
            'as'=>'SwarakReplacement/request',
            'uses'=>'User\SwarakReplacementController@request'
        ])->middleware('can:isInTask, "admin:cr"');

        Route::get('', [
            'as'=>'SwarakReplacement/index',
            'uses'=>'User\SwarakReplacementController@index'
        ])->middleware('can:isInTask, "admin:cr"');

        Route::get('/details-view/{id}', [
            'as'=>'SwarakReplacement/details',
            'uses'=>'User\SwarakReplacementController@details'
        ])->middleware('can:isInTask, "admin:cr"');

        Route::get('/review/{id}', [
            'as'=>'SwarakReplacement/review',
            'uses'=>'User\SwarakReplacementController@review'
        ])->middleware('can:isInTask, "admin:cr"');

        Route::get('/cancel/{id}', [
            'as'=>'SwarakReplacement/cancel',
            'uses'=>'User\SwarakReplacementController@cancel'
        ])->middleware('can:isInTask, "admin:cr"');

        Route::post('/swarak-store/{id}', [
            'as'=>'SwarakReplacement/store',
            'uses'=>'User\SwarakReplacementController@store'
        ])->middleware('can:isInTask, "admin:cr"');

    });

    //failed application route :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('failed')->middleware('can:isInTask, "admin:fa"')->group(function (){

        Route::get('', [
            'as'=>'failed',
            'uses'=>'User\FailedApplicationController@index'
        ]);

        Route::get('/application-view/{id}', [
            'as'=>'failed/app_view',
            'uses'=>'User\FailedApplicationController@applicationView'
        ]);

        Route::get('/paper-view/{id}', [
            'as'=>'failed/paper_view',
            'uses'=>'User\FailedApplicationController@paperView'
        ]);

        Route::get('/report-view/{id}', [
            'as'=>'failed/report_view',
            'uses'=>'User\FailedApplicationController@reportView'
        ]);

        Route::get('/letters/{id}', [
            'as'=>'failed/letters',
            'uses'=>'User\FailedApplicationController@letters'
        ]);

        Route::get('/Restore/{id}', [
            'as'=>'failed/Restore',
            'uses'=>'User\FailedApplicationController@restore'
        ]);

        Route::post('/restore-application/{id}', [
            'as'=>'failed/RestoreApplication',
            'uses'=>'User\FailedApplicationController@restoreApplication'
        ]);

    });

    //Cancel application route :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('cancel')->middleware('can:isInTask, "admin:ca"')->group(function (){

        Route::get('', [
            'as'=>'Cancel',
            'uses'=>'User\CancelApplicationController@index'
        ]);

        Route::get('/application-view/{id}', [
            'as'=>'Cancel/app_view',
            'uses'=>'User\CancelApplicationController@applicationView'
        ]);

        Route::get('/paper-view/{id}', [
            'as'=>'Cancel/paper_view',
            'uses'=>'User\CancelApplicationController@paperView'
        ]);

        Route::post('/restore-application/{id}', [
            'as'=>'Cancel/RestoreApplication',
            'uses'=>'User\CancelApplicationController@restoreApplication'
        ]);
    });

    //Report route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('report')->group(function (){

        //day range report ::::::::::::::::::::::::
        Route::get('/day-range', [
            'as'=>'report/dayRange',
            'uses'=>'User\ReportController@dayRange'
        ]);

        Route::post('/day-range/receive-report', [
            'as'=>'report/dayRange/dayRangeReport',
            'uses'=>'User\ReportController@dayRangeReceive'
        ]);

        Route::post('/day-range/forward-report', [
            'as'=>'report/dayRange/forward',
            'uses'=>'User\ReportController@dayRangeForward'
        ]);

        Route::post('/receipaint/', [
            'as'=>'report/getRecipaint',
            'uses'=>'User\ReportController@getRecipaint'
        ]);

        Route::post('/get-forward-user/', [
            'as'=>'report/getForwardUser',
            'uses'=>'User\ReportController@getForwardUser'
        ]);

        Route::get('/application-position', [
            'as'=>'report/position',
            'uses'=>'User\ReportController@position'
        ])->middleware('can:isInTask, "admin:pr"');

        Route::get('/application-position/applicationDetails/{id}/{type}', [
            'as'=>'report/position/details',
            'uses'=>'User\ReportController@ApplicationDetails'
        ])->middleware('can:isInTask, "admin:pr"');

        Route::get('/betterment-fee', [
            'as'=>'report/bettermentFee',
            'uses'=>'User\ReportController@bettermentFee'
        ])->middleware('can:isInTask, "admin:bfr"');

        Route::get('/letter-issue', [
            'as'=>'report/letterIssue',
            'uses'=>'User\ReportController@letterIssue'
        ])->middleware('can:isInTask, "admin:er"');

        Route::get('/certificate-issue', [
            'as'=>'report/certificateIssue',
            'uses'=>'User\ReportController@certificateIssue'
        ])->middleware('can:isInTask, "admin:er"');

        Route::get('/land-use', [
            'as'=>'report/landUse',
            'uses'=>'User\ReportController@landUse'
        ])->middleware('can:isInTask, "admin:lur"');

        Route::get('/land-use-summary', [
            'as'=>'report/landUseSummary',
            'uses'=>'User\ReportController@landUseSummary'
        ])->middleware('can:isInTask, "admin:lur"');

        Route::get('/application-restore-report', [
            'as'=>'report/RestoreReport',
            'uses'=>'User\ReportController@restoreReport'
        ])->middleware('can:isInTask, "admin"');
    });

});


Route::post('/user-info', [
    'as'=>'user/Info',
    'uses'=>'User\ApplicationController@userInfo'
]);
