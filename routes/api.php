<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// TODAY ROUTES
Route::get('today', [PictureController::class, 'getTodayPosts']);

// LIVE STREAM ROUTES
Route::get('streams', [StreamController::class, 'getLiveStream']);
Route::get('stream/cover/{streamId}', [StreamController::class, 'viewCoverFile']);

// VIDEOS ROUTES
Route::get('videos', [VideoController::class, 'getAllVideos']);
Route::get('video/file/{videoId}', [VideoController::class, 'viewVideoFile']);

// PICTURES ROUTES
Route::get('pictures', [PictureController::class, 'getAllPictures']);
Route::get('picture/file/{pictureId}', [PictureController::class, 'viewPictureFile']);
