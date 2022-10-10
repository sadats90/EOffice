<?php

Route::prefix('work-handover')->middleware(['auth', 'can:isInTask,"wh"'])->group(function () {

    Route::prefix('application')->group(function () {

        //forwarded Application Routes :::::::::::::::::::::::::::::::::::::::::::::::::::::::
        Route::get('', [
            'as'=>'workHandover/Application',
            'uses'=>'Handover\ApplicationController@index'
        ]);

        Route::get('/back', [
            'as'=>'workHandover/BackApplication',
            'uses'=>'Handover\ApplicationController@back'
        ]);

        Route::get('/wait', [
            'as'=>'workHandover/WaitApplication',
            'uses'=>'Handover\ApplicationController@Wait'
        ]);

        Route::get('/view-application/{id}', [
            'as'=>'workHandover/application/view',
            'uses'=>'Handover\ApplicationController@view'
        ]);

        Route::get('/view-paper/{id}', [
            'as'=>'workHandover/application/viewPaper',
            'uses'=>'Handover\ApplicationController@viewPaper'
        ]);
        Route::get('/report/{id}', [
            'as'=>'workHandover/application/report',
            'uses'=>'Handover\ApplicationController@report'
        ]);

        //Forward Routes
        Route::get('/forward/{id}', [
            'as'=>'workHandover/application/forward',
            'uses'=>'Handover\ForwardController@index'
        ]);

        Route::post('/forward/{id}/{to_user_id}', [
            'as'=>'workHandover/application/forward/Create',
            'uses'=>'Handover\ForwardController@store'
        ]);

    });
    //letter Issue route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('letter')->group(function () {

        Route::get('/list/{id}', [
            'as'=>'Handover/Letter',
            'uses'=>'Handover\LetterController@index'
        ]);

        Route::get('/create/{id}/{hit}', [
            'as'=>'Handover/Letter/Create',
            'uses'=>'Handover\LetterController@create'
        ]);

        Route::post('/create/{id}/{hit}', [
            'as'=>'Handover/Letter/store',
            'uses'=>'Handover\LetterController@store'
        ]);

        Route::get('/edit/{id}/{app_id}/{hit}', [
            'as'=>'Handover/Letter/edit',
            'uses'=>'Handover\LetterController@edit'
        ]);

        Route::post('/edit/{id}/{app_id}/{hit}', [
            'as'=>'Handover/Letter/update',
            'uses'=>'Handover\LetterController@update'
        ]);

        Route::get('/view/{id}/{app_id}', [
            'as'=>'Handover/Letter/show',
            'uses'=>'Handover\LetterController@show'
        ]);

        Route::get('/delete/{id}/{app_id}/{hit}/{userId}', [
            'as'=>'Handover/Letter/delete',
            'uses'=>'Handover\LetterController@delete'
        ]);

        Route::get('/sent/{id}/{app_id}/{hit}/{userId}', [
            'as'=>'Handover/Letter/sent',
            'uses'=>'Handover\LetterController@sent'
        ]);

        Route::get('/solve-view/{id}/{userId}', [
            'as'=>'Handover/Letter/solveReview',
            'uses'=>'Handover\LetterController@solveReview'
        ]);

    });

    //Certificate Issue route ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('certificate')->group(function () {

        Route::post('/{id}', [
            'as'=>'Handover/certificate',
            'uses'=>'Handover\CertificateController@store'
        ]);

        Route::get('/reset/{id}', [
            'as'=>'Handover/certificate/reset',
            'uses'=>'Handover\CertificateController@reset'
        ]);

        Route::get('/view/{id}/{userId}', [
            'as'=>'Handover/certificate/view',
            'uses'=>'Handover\CertificateController@view'
        ]);

        Route::get('/issue/{id}/{userId}', [
            'as'=>'Handover/certificate/issue',
            'uses'=>'Handover\CertificateController@issue'
        ]);

        Route::get('/complete/{id}/{userId}', [
            'as'=>'Handover/certificate/complete',
            'uses'=>'Handover\CertificateController@complete'
        ]);

    });
});

