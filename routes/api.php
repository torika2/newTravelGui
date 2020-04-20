<?php

use Illuminate\Http\Request;

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
Route::post('/register', 'Api\AuthController@register');
Route::post('/check_nick','Api\RegisterCheck@checknickname');
Route::post('/check_email','Api\RegisterCheck@checkemail');
Route::post('/login', 'Api\AuthController@login');


Route::get('/get_first_frame','HomeController@get_first_frame');
Route::post('/get_first_frame','HomeController@get_first_frame');
Route::get('index','HomeController@index');

Route::post('/upload_video','HomeController@video');




Route::post('/upload_photo','HomeController@photo');
Route::post('/make_clips','HomeController@createclip');
// Route::put('get_first_frame','HomeController@get_first_frame');



/*userActions*/
Route::post('/follow','Api\UserActionsController@SetFollower');
Route::post('/get_story','Api\UserActionsController@GetStory');
Route::post('/like_story','Api\UserActionsController@LikeStory');
Route::post('/add_to_favs','Api\UserActionsController@MarkFav');
Route::post('/delete/story','Api\UserActionsController@deleteStory');
Route::post("/delete/profile","Api\UserActionsController@deleteownimage");


Route::post('/text/frame','Api\UserActionsController@languageFrame');