<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// language routes
route::get('/change-language/{lng}',[
    'as'    =>  'ChangeLanguage',
    'uses'  =>  'LanguageController@ChangeLanguage'
]);

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [
    'as'=>'Dashboard',
    'uses'=>'User\DashboardController@index'
]);


//User route
Route::prefix('profile')->group(function (){
    Route::get('/', [
        'as'=>'Profile',
        'uses'=>'User\ProfileController@index'
    ]);

    Route::post('/change-password', [
        'as'=>'profile/changePassword',
        'uses'=>'User\ProfileController@UpdatePassword'
    ]);

    Route::post('/change-profile-picture/{id}', [
        'as'=>'profile/changeProfilePicture',
        'uses'=>'User\ProfileController@changeProfilePicture'
    ]);

    Route::post('/change-signature/{id}', [
        'as'=>'profile/changeSignature',
        'uses'=>'User\ProfileController@changeSignature'
    ]);

    Route::post('/change-info/{id}', [
        'as'=>'profile/changeInfo',
        'uses'=>'User\ProfileController@changeInfo'
    ]);

});

Route::get('/home', 'User\DashboardController@index')->name('home');

Route::get('/qrcode', 'QrCodeController@index');