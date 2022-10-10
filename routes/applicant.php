<?php

use Illuminate\Support\Facades\Route;


Route::get('/applicant/register', [
    'as'=>'applicant/Register',
    'uses'=>'Applicant\RegisterController@index'
]);
Route::post('/applicant/store', [
    'as'=>'applicant/Store',
    'uses'=>'Applicant\RegisterController@store'
]);
Route::get('/applicant/verify-mobile', 'Applicant\DashboardController@VerifyMobile');

Route::get('/applicant/send-verification-code',[
    'as'    =>  'applicant/SendVerificationCode',
    'uses'  =>  'Applicant\DashboardController@SendVerificationCode'
]);

Route::post('/applicant/verify-code',[
    'as'    =>  'applicant/VerifyCode',
    'uses'  =>  'Applicant\DashboardController@VerifyCode'
]);

Route::post('/get-service-charge', [
    'as'=>'GetServiceCharge',
    'uses'=>'Applicant\ApplicationController@getServiceCharge'
]);

Route::post('/get-branches', [
    'as'=>'GetBranches',
    'uses'=>'Applicant\ApplicationController@getBranches'
]);

Route::prefix('applicant')->middleware(['auth', 'verifyMobile'])->group(function (){

    Route::get('/dashboard', 'Applicant\DashboardController@Index');

    Route::get('/applications', [
        'as'=>'applicant/applications/Index',
        'uses'=>'Applicant\ApplicationController@Index'
    ]);

    //Profile Portion Route
    Route::get('/change-password', [
        'as'=>'applicant/user/changePassword',
        'uses'=>'Applicant\UserController@changePassword'
    ]);

    Route::post('/update-password', [
        'as'=>'applicant/user/updatePassword',
        'uses'=>'Applicant\UserController@updatePassword'
    ]);

    Route::get('/change-profile-picture', [
        'as'=>'applicant/user/changeProfilePic',
        'uses'=>'Applicant\UserController@changeProfilePic'
    ]);

    Route::post('/update-profile-picture', [
        'as'=>'applicant/user/updateProfilePic',
        'uses'=>'Applicant\UserController@updateProfilePic'
    ]);

//Application Track
//    Route::get('/track', [
//        'as'=>'applicant/applications/track',
//        'uses'=>'Applicant\TrackController@track'
//    ]);
//    Route::get('/track-result', [
//        'as'=>'applicant/applications/trackResult',
//        'uses'=>'Applicant\TrackController@trackResult'
//    ]);

    Route::get('/applications/form/{id}', [
        'as'=>'applicant/applications/Form',
        'uses'=>'Applicant\ApplicationController@form'
    ]);

    Route::post('/applications/personal-info/{app_id}', [
        'as'=>'applicant/applications/Store/PersonalInfo',
        'uses'=>'Applicant\ApplicationController@personalInfo'
    ]);

    Route::post('/applications/land-info/{app_id}', [
        'as'=>'applicant/applications/Store/LandInfo',
        'uses'=>'Applicant\ApplicationController@landInfo'
    ]);

    Route::post('/applications/document-info/{app_id}', [
        'as'=>'applicant/applications/Store/DocumentInfo',
        'uses'=>'Applicant\ApplicationController@documentInfo'
    ]);

    Route::post('/applications/document-info/{app_id}', [
        'as'=>'applicant/applications/Store/documentInfo',
        'uses'=>'Applicant\ApplicationController@documentInfo'
    ]);

    Route::get('/applications/document-view/{id}', [
        'as'=>'applicant/applications/Store/document/view',
        'uses'=>'Applicant\ApplicationController@documentView'
    ]);

    Route::post('/applications/submit/{app_id}', [
        'as'=>'applicant/applications/submit',
        'uses'=>'Applicant\ApplicationController@submit'
    ]);

    Route::get('/applications/viewDetails/{id}', [
        'as'=>'applicant/applications/viewDetails',
        'uses'=>'Applicant\ApplicationController@viewDetails'
    ]);

    Route::get('/applications/correction-request/{id}', [
        'as'=>'applicant/applications/correctionRequest',
        'uses'=>'Applicant\ApplicationController@correctionRequest'
    ]);

    Route::post('/applications/correction-request/{id}', [
        'as'=>'applicant/applications/correctionRequestStore',
        'uses'=>'Applicant\ApplicationController@correctionRequestStore'
    ]);

    Route::get('/applications/correction-request-preview/{id}', [
        'as'=>'applicant/applications/correctionRequestPreview',
        'uses'=>'Applicant\ApplicationController@correctionRequestPreview'
    ]);

    Route::get('/applications/correction-request-sent/{id}', [
        'as'=>'applicant/applications/correctionRequestSent',
        'uses'=>'Applicant\ApplicationController@correctionRequestSent'
    ]);

    Route::post('/applications/store/{id}', [
        'as'=>'applicant/applications/Store',
        'uses'=>'Applicant\ApplicationController@store'
    ]);

    Route::get('/buy-application', [
        'as'=>'applicant/application/Buy',
        'uses'=>'Applicant\ApplicationController@Buy'
    ]);
    Route::get('/buy-application/app-type/{id}', [
        'as'=>'applicant/application/Buy/app-type',
        'uses'=>'Applicant\ApplicationController@appType'
    ]);

    Route::post('/application/payment', [
        'as'=>'applicant/application/Payment',
        'uses'=>'Applicant\ApplicationController@Payment'
    ]);

    Route::post('/application/back-from-payment', [
        'as'=>'applicant/application/BackFromPayment',
        'uses'=>'Applicant\ApplicationController@BackFromPayment'
    ]);

    Route::post('/application/confirm-payment/{app_type}/{flu}', [
        'as'=>'applicant/application/ConfirmPayment',
        'uses'=>'Applicant\ApplicationController@ConfirmPayment'
    ]);

//letter route
    Route::prefix('letter')->group(function (){
        Route::get('/', [
            'as'=>'applicant/letters',
            'uses'=>'Applicant\LettersController@index'
        ]);

        Route::get('/view/{id}/{app_id}', [
            'as'=>'applicant/letters/view',
            'uses'=>'Applicant\LettersController@show'
        ]);

        Route::get('/feedback/{id}', [
            'as'=>'applicant/letters/feedback',
            'uses'=>'Applicant\LettersController@feedBack'
        ]);

        Route::post('/feedback/{id}', [
            'as'=>'applicant/letters/feedbackStore',
            'uses'=>'Applicant\LettersController@feedbackStore'
        ]);

        Route::post('/paper-submit/{id}', [
            'as'=>'applicant/letters/paperSubmit',
            'uses'=>'Applicant\LettersController@paperSubmit'
        ]);

        Route::post('/promise-submit/{id}', [
            'as'=>'applicant/letters/promiseSubmit',
            'uses'=>'Applicant\LettersController@promiseStore'
        ]);

        Route::get('/paper-view/{id}/{d_t_id}', [
            'as'=>'applicant/letters/paperView',
            'uses'=>'Applicant\LettersController@paperView'
        ]);

        Route::post('/payment/{id}', [
            'as'=>'applicant/letter/Payment',
            'uses'=>'Applicant\LettersController@Payment'
        ]);

        Route::post('/back-from-payment/{id}/{msg}', [
            'as'=>'applicant/letter/BackFromPayment',
            'uses'=>'Applicant\LettersController@BackFromPayment'
        ]);

        Route::post('/confirm-payment/{id}', [
            'as'=>'applicant/letter/ConfirmPayment',
            'uses'=>'Applicant\LettersController@ConfirmPayment'
        ]);
    });
});



