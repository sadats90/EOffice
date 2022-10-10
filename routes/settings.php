<?php

Route::prefix('settings')->middleware(['auth', 'can:isInTask,"admin"'])->group(function () {

    //CertificateText Route
    Route::get('/Certificate-text', [
        'as'=>'CertificateText',
        'uses'=>'User\CertificateTextController@index'
    ]);
    Route::get('/Certificate-text-add', [
        'as'=>'CertificateText/Create',
        'uses'=>'User\CertificateTextController@create'
    ]);
    Route::post('/Certificate-text-add', [
        'as'=>'CertificateText/Store',
        'uses'=>'User\CertificateTextController@store'
    ]);

    Route::get('/Certificate-text-edit/{id}', [
        'as'=>'CertificateText/Edit',
        'uses'=>'User\CertificateTextController@edit'
    ]);
    Route::post('/Certificate-text-edit/{id}', [
        'as'=>'CertificateText/Update',
        'uses'=>'User\CertificateTextController@update'
    ]);
    Route::delete('/Certificate-text-delete/{id}', [
        'as'=>'CertificateText/Delete',
        'uses'=>'User\CertificateTextController@destroy'
    ]);

    //Project Route
    Route::get('/project', [
        'as'=>'Project',
        'uses'=>'User\ProjectController@index'
    ]);
    Route::get('/project-add', [
        'as'=>'Project/Create',
        'uses'=>'User\ProjectController@create'
    ]);
    Route::post('/project-add', [
        'as'=>'Project/Store',
        'uses'=>'User\ProjectController@store'
    ]);

    Route::get('/project-edit/{id}', [
        'as'=>'Project/Edit',
        'uses'=>'User\ProjectController@edit'
    ]);
    Route::post('/project-edit/{id}', [
        'as'=>'Project/Update',
        'uses'=>'User\ProjectController@update'
    ]);
    Route::delete('/project-delete/{id}', [
        'as'=>'Project/Delete',
        'uses'=>'User\ProjectController@destroy'
    ]);

    //District Route
    Route::get('/district', [
        'as'=>'District',
        'uses'=>'User\DistrictController@index'
    ]);
    Route::get('/district-add', [
        'as'=>'District/Create',
        'uses'=>'User\DistrictController@create'
    ]);
    Route::post('/district-add', [
        'as'=>'District/Store',
        'uses'=>'User\DistrictController@store'
    ]);

    Route::get('/district-edit/{id}', [
        'as'=>'District/Edit',
        'uses'=>'User\DistrictController@edit'
    ]);
    Route::post('/district-edit/{id}', [
        'as'=>'District/Update',
        'uses'=>'User\DistrictController@update'
    ]);
    Route::delete('/district-delete/{id}', [
        'as'=>'District/Delete',
        'uses'=>'User\DistrictController@destroy'
    ]);

    //Fees Route
    Route::get('/fees', [
        'as'=>'Fee',
        'uses'=>'User\FeeController@index'
    ]);
    Route::post('/fees-store', [
        'as'=>'Fee/Store',
        'uses'=>'User\FeeController@store'
    ]);

//Upazila Route
    Route::get('/upazila', [
        'as'=>'Upazila',
        'uses'=>'User\UpazilaController@index'
    ]);
    Route::get('/upazila-add', [
        'as'=>'Upazila/Create',
        'uses'=>'User\UpazilaController@create'
    ]);
    Route::post('/upazila-add', [
        'as'=>'Upazila/Store',
        'uses'=>'User\UpazilaController@store'
    ]);

    Route::get('/upazila-edit/{id}', [
        'as'=>'Upazila/Edit',
        'uses'=>'User\UpazilaController@edit'
    ]);
    Route::post('/upazila-edit/{id}', [
        'as'=>'Upazila/Update',
        'uses'=>'User\UpazilaController@update'
    ]);
    Route::delete('/upazila-delete/{id}', [
        'as'=>'Upazila/Delete',
        'uses'=>'User\UpazilaController@destroy'
    ]);

    //Mouza Area Route
    Route::get('/mouza-area', [
        'as'=>'MouzaAreas',
        'uses'=>'User\MouzaAreaController@index'
    ]);
    Route::get('/mouza-area-add', [
        'as'=>'MouzaAreas/Create',
        'uses'=>'User\MouzaAreaController@create'
    ]);
    Route::post('/mouza-area-add', [
        'as'=>'MouzaAreas/Store',
        'uses'=>'User\MouzaAreaController@store'
    ]);

    Route::get('/mouza-area-edit/{id}', [
        'as'=>'MouzaAreas/Edit',
        'uses'=>'User\MouzaAreaController@edit'
    ]);
    Route::post('/mouza-area-edit/{id}', [
        'as'=>'MouzaAreas/Update',
        'uses'=>'User\MouzaAreaController@update'
    ]);
    Route::delete('/mouza-area-delete/{id}', [
        'as'=>'MouzaAreas/Delete',
        'uses'=>'User\MouzaAreaController@destroy'
    ]);

    // Designation Route
    Route::get('/designation', [
        'as'=>'Designation',
        'uses'=>'User\DesignationController@index'
    ]);
    Route::get('/designation/add', [
        'as'=>'Designation/Create',
        'uses'=>'User\DesignationController@create'
    ]);
    Route::post('/designation/add', [
        'as'=>'Designation/Store',
        'uses'=>'User\DesignationController@store'
    ]);

    Route::get('/designation/edit/{id}', [
        'as'=>'Designation/Edit',
        'uses'=>'User\DesignationController@edit'
    ]);
    Route::post('/designation/edit/{id}', [
        'as'=>'Designation/Update',
        'uses'=>'User\DesignationController@update'
    ]);
    Route::delete('/designation/delete/{id}', [
        'as'=>'Designation/Delete',
        'uses'=>'User\DesignationController@destroy'
    ]);

    // Land Use Future Type
    Route::get('/land-use-future-type', [
        'as'=>'LandUseFuture',
        'uses'=>'User\LandUseTypeFutureController@index'
    ]);
    Route::get('/land-use-future-type/add', [
        'as'=>'LandUseFuture/Create',
        'uses'=>'User\LandUseTypeFutureController@create'
    ]);
    Route::post('/land-use-future-type/add', [
        'as'=>'LandUseFuture/Store',
        'uses'=>'User\LandUseTypeFutureController@store'
    ]);

    Route::get('/land-use-future-type/edit/{id}', [
        'as'=>'LandUseFuture/Edit',
        'uses'=>'User\LandUseTypeFutureController@edit'
    ]);
    Route::post('/land-use-future-type/edit/{id}', [
        'as'=>'LandUseFuture/Update',
        'uses'=>'User\LandUseTypeFutureController@update'
    ]);
    Route::delete('/land-use-future-type/delete/{id}', [
        'as'=>'LandUseFuture/Delete',
        'uses'=>'User\LandUseTypeFutureController@destroy'
    ]);
    Route::get('/land-use-future-type/disable/{id}', [
        'as'=>'LandUseFuture/Disable',
        'uses'=>'User\LandUseTypeFutureController@disable'
    ]);
    Route::get('/land-use-future-type/enable/{id}', [
        'as'=>'LandUseFuture/Enable',
        'uses'=>'User\LandUseTypeFutureController@enable'
    ]);

    // Land Use Type Present
    Route::get('/land-use-present-type', [
        'as'=>'LandUsePresent',
        'uses'=>'User\LandUseTypePresentController@index'
    ]);
    Route::get('/land-use-present-type/add', [
        'as'=>'LandUsePresent/Create',
        'uses'=>'User\LandUseTypePresentController@create'
    ]);
    Route::post('/land-use-present-type/add', [
        'as'=>'LandUsePresent/Store',
        'uses'=>'User\LandUseTypePresentController@store'
    ]);

    Route::get('/land-use-present-type/edit/{id}', [
        'as'=>'LandUsePresent/Edit',
        'uses'=>'User\LandUseTypePresentController@edit'
    ]);
    Route::post('/land-use-present-type/edit/{id}', [
        'as'=>'LandUsePresent/Update',
        'uses'=>'User\LandUseTypePresentController@update'
    ]);
    Route::delete('/land-use-present-type/delete/{id}', [
        'as'=>'LandUsePresent/Delete',
        'uses'=>'User\LandUseTypePresentController@destroy'
    ]);
    Route::get('/land-use-present-type/disable/{id}', [
        'as'=>'LandUsePresent/Disable',
        'uses'=>'User\LandUseTypePresentController@disable'
    ]);
    Route::get('/land-use-present-type/enable/{id}', [
        'as'=>'LandUsePresent/Enable',
        'uses'=>'User\LandUseTypePresentController@enable'
    ]);

    // user Route
    Route::get('/user', [
        'as'=>'User',
        'uses'=>'User\UserController@index'
    ]);
    Route::get('/user/add', [
        'as'=>'User/Create',
        'uses'=>'User\UserController@create'
    ]);
    Route::post('/user/add', [
        'as'=>'User/Store',
        'uses'=>'User\UserController@store'
    ]);

    Route::get('/user/work-handover/{id}', [
        'as'=>'User/WorkHandover',
        'uses'=>'User\UserController@workHandover'
    ]);

    Route::post('/user/work-handover/{id}', [
        'as'=>'User/WorkHandoverStore',
        'uses'=>'User\UserController@workHandoverStore'
    ]);
    Route::get('/user/cancel-work-handover/{id}', [
        'as'=>'User/CancelWorkHandover',
        'uses'=>'User\UserController@cancelWorkHandover'
    ]);

    Route::get('/user/working-permission/{id}', [
        'as'=>'User/WorkingPermission',
        'uses'=>'User\UserController@workingPermission'
    ]);

    Route::post('/user/working-permission/{id}', [
        'as'=>'User/WorkingPermissionStore',
        'uses'=>'User\UserController@workingPermissionStore'
    ]);
    Route::get('/user/working-permission/delete/{id}', [
        'as'=>'User/WorkingPermission/Delete',
        'uses'=>'User\UserController@workingPermissionDelete'
    ]);

    Route::get('/user/forward-permission/{id}', [
        'as'=>'User/ForwardPermission',
        'uses'=>'User\UserController@forwardPermission'
    ]);
    Route::post('/user/forward-permission/{id}', [
        'as'=>'User/ForwardPermissionStore',
        'uses'=>'User\UserController@forwardPermissionStore'
    ]);
    Route::get('/user/forward-permission/delete/{id}', [
        'as'=>'User/ForwardPermission/Delete',
        'uses'=>'User\UserController@forwardPermissionDelete'
    ]);
    Route::get('/user/details/{id}', [
        'as'=>'User/Show',
        'uses'=>'User\UserController@show'
    ]);
    Route::get('/user/edit/{id}', [
        'as'=>'User/Edit',
        'uses'=>'User\UserController@edit'
    ]);
    Route::post('/user/edit/{id}', [
        'as'=>'User/Update',
        'uses'=>'User\UserController@update'
    ]);

    Route::delete('/user/delete/{id}', [
        'as'=>'User/Delete',
        'uses'=>'User\UserController@destroy'
    ]);

    Route::get('/user/active/{id}', [
        'as'=>'User/active',
        'uses'=>'User\UserController@active'
    ]);

    Route::get('/user/inactive/{id}', [
        'as'=>'User/inactive',
        'uses'=>'User\UserController@inactive'
    ]);

    // Backup Database --------------------------------------------
    Route::prefix('database')->group(function () {

        Route::get('/backup', [
            'as'      =>  'database/backup',
            'uses'    =>  'User\DatabaseController@BackupDatabase',
        ]);

        Route::get('/process', [
            'as'      =>  'database/ProcessDatabase',
            'uses'    =>  'User\DatabaseController@ProcessDatabase',
        ]);

        Route::get('/download', [
            'as'      =>  'database/DownloadDatabase',
            'uses'    =>  'User\DatabaseController@DownloadDatabase',
        ]);
    });
});



Route::get('/getUpazila/{id}','User\UpazilaController@getUpazila');
Route::get('/getUsersByDesignation/{id}/{user_id}','User\UserController@getUsersByDesignation');

Route::post('/mouza-area/by_upazila_id', [
    'as'=>'MouzaAreas/ByUpazilaId',
    'uses'=>'User\MouzaAreaController@getMouzaAreas'
]);

