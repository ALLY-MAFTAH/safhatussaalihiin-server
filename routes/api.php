<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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
Route::get('today', [PostController::class, 'getTodayPosts']);

// LIVE STREAM ROUTES
Route::get('streams', [StreamController::class, 'getLiveStream']);
Route::get('stream/cover/{streamId}', [StreamController::class, 'viewCoverFile']);


// POSTS ROUTES
Route::get('posts', [PostController::class, 'getAllPosts']);
Route::get('post/picture_file_1/{postId}', [PostController::class, 'viewPictureFile1']);
Route::get('post/picture_file_2/{postId}', [PostController::class, 'viewPictureFile2']);
Route::get('post/picture_file_3/{postId}', [PostController::class, 'viewPictureFile3']);
Route::get('post/video_file_1/{postId}', [PostController::class, 'viewVideoFile1']);
Route::get('post/video_file_2/{postId}', [PostController::class, 'viewVideoFile2']);

