<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\YearController;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () {


        Route::get('change_password', [HomeController::class, 'changePasswordRoute'])->name('change_password');
        Route::post('/changePassword', [HomeController::class, 'changePassword'])->name('changePassword');



    // TODAY ROUTE
    Route::get('today', 'App\Http\Controllers\PictureController@getTodayPosts')->name('today');


    // LIVE STREAM ROUTES
    Route::get('live_stream', [StreamController::class,'getLiveStream'])->name('live_stream');
    Route::post('add_stream', [StreamController::class,'postLiveStream'])->name('add_stream');
    Route::put('edit_stream/{streamId}', [StreamController::class,'putLiveStream'])->name('edit_stream');
    Route::get('delete_stream/{streamId}', [StreamController::class,'deleteLiveStream'])->name('delete_stream');
    Route::put('toggle_status/{stream}/status', [StreamController::class, 'toggleStatus'])->name('toggle_status');



    // PICTURES  ROUTES
    Route::get('pictures', [PictureController::class,'getAllPictures'])->name('pictures');
    Route::post('add_picture/{monthId}', [PictureController::class,'postPicture'])->name('add_picture');
    Route::put('edit_picture/{pictureId}', [PictureController::class,'putPicture'])->name('edit_picture');
    Route::get('delete_picture/{pictureId}', [PictureController::class,'deletePicture'])->name('delete_picture');


    // VIDEOS  ROUTES
    Route::get('videos', [VideoController::class,'getAllVideos'])->name('videos');
    Route::post('add_video/{monthId}', [VideoController::class,'postVideo'])->name('add_video');
    Route::put('edit_video/{videoId}', [VideoController::class,'putVideo'])->name('edit_video');
    Route::get('delete_video/{videoId}', [VideoController::class,'deleteVideo'])->name('delete_video');

    // MONTHS  ROUTES
    Route::get('year/{yearId}', [MonthController::class,'getAllMonths'])->name('year');
    Route::post('add_month/{yearId}', [MonthController::class,'postMonth'])->name('add_month');
    Route::put('edit_month/{monthId}', [MonthController::class,'putMonth'])->name('edit_month');
    Route::get('delete_month/{monthId}', [MonthController::class,'deleteMonth'])->name('delete_month');

    // YEARS  ROUTES
    Route::get('media', [YearController::class,'getAllYears'])->name('media');
    Route::post('add_year', [YearController::class,'postYear'])->name('add_year');
    Route::put('edit_year/{yearId}', [YearController::class,'putYear'])->name('edit_year');
    Route::get('delete_year/{yearId}', [YearController::class,'deleteYear'])->name('delete_year');

    // // MEDIA ROUTES
    Route::get('month/{monthId}', [MonthController::class,'getAllMedia'])->name('month');

});
