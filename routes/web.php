<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'AuthController@index')->name('home');
			// ADMIN PAGE
Route::get('/admin', 'AdminPageController@home')->name('adminHome');
			// ADMIN PROFILE PAGE
Route::get('/admin/profile','AdminPageController@profile')->name('adminProfile');
Route::post('/admin/add/picture','AdminPageController@uploadPhoto')->name('uploadPhoto');
Route::post('/admin/add/info','AdminPageController@addAdminProfileInfo')->name('addAdminProfileInfo');
			// EVENTS 
Route::get('/admin/event','AdminPageController@tourPage')->name('tourPage');
Route::post('/admin/event/create','AdminPageController@createEvent')->name('createEvent');
Route::post('/admin/event/control','AdminPageController@editEventPage')->name('editEventPage');
Route::post('/admin/event/edit/image','AdminPageController@editEventImage')->name('editEventImage');
Route::delete('/admin/event/delete','AdminPageController@deleteEvent')->name('deleteEvent');
Route::post('/admin/event/search','AdminPageController@searchEvent')->name('searchEvent');
Route::delete('/admin/event/control/delete','AdminPageController@deleteReviewReply')->name('deleteReviewReply');
Route::delete('/admin/event/image/delete','AdminPageController@deleteEventImage')->name('deleteEventImage');
Route::post('/admin/event/image/sort','AdminPageController@sortingEventImages')->name('sortingEventImages');
Route::post('/admin/event/edit/text','AdminPageController@editEvent')->name('editEvent');
Route::post('/admin/event/image/get','AdminPageController@getEventImages')->name('getEventImages');
Route::post('/admin/get/event/image','AdminPageController@getEventImages')->name('getEventImages');
Route::post('admin/image/upload','AdminPageController@uploadEventImage')->name('uploadEventImage');
			// LOGS CONTROLLER
Route::get('/admin/info','AdminPageController@infoPage')->name('infoPage');
Route::post('/admin/info/search','AdminPageController@searchInfo')->name('searchInfo');
			// PAGES 
Route::get('/admin/frame','AdminPageController@frameControl')->name('frameControl');
Route::post('/admin/frame/create','AdminPageController@createPage')->name('createPage');
Route::post('/admin/frame/control','AdminPageController@frameEdit')->name('frameEdit');
Route::post('/admin/frame/image','AdminPageController@frameImage')->name('frameImage');
Route::post('/admin/frame/get/image','AdminPageController@getPageImages')->name('getPageImages');
Route::post('/admin/frame/update','AdminPageController@pageUpdate')->name('pageUpdate');
Route::post('/admin/frame/image/size','AdminPageController@frameImageSizingPage')->name('frameImageSizingPage');
Route::post('/admin/frame/image/size/make','AdminPageController@frameImageSizing')->name('frameImageSizing');
Route::delete('/admin/page/delete','AdminPageController@deletePage')->name('deletePage');
Route::post('/admin/page/logo','AdminPageController@logoUpload')->name('logoUpload');
Route::post('/admin/page/image/delete','AdminPageController@deletePageImage')->name('deletePageImage');
Route::post('/admin/page/logo/get','AdminPageController@getPageLogos')->name('getPageLogos');
Route::post('/admin/page/button/image','AdminPageController@createPageButton')->name('createPageButton');
		//PAGE COLORS
Route::get('/admin/page/color/get/{params}','AdminPageController@getPageColor')->name('getPageColor');
Route::post('/admin/page/color','AdminPageController@pageColor')->name('pageColor');
Route::post('/admin/page/color/delete','AdminPageController@deleteColor')->name('deleteColor');
		//PAGE BUTTONS
Route::get('/admin/button/','AdminPageController@buttonPage')->name('buttonPage');
Route::get('/admin/page/button/delete/{id}','AdminPageController@pageButtonDelete')->name('pageButtonDelete');
Route::get('/admin/page/button/get','AdminPageController@getPageButtons')->name('getPageButtons');
Route::post('/admin/page/button/is_enable/','AdminPageController@is_enable')->name('is_enable');
		//PAGE SLOGAN
Route::get('/admin/slogan/','AdminPageController@sloganPage')->name('sloganPage');
Route::post('/admin/page/slogan/create','AdminPageController@pageSloganCreate')->name('pageSloganCreate');
Route::post('/admin/page/slogan/edit','AdminPageController@editPageSlogan')->name('editPageSlogan');
		// Language 
Route::get('/admin/lang','AdminPageController@langPage')->name('langPage');
Route::post('/admin/lang/translate','AdminPageController@translate')->name('translate');
Route::post('/admin/lang/add/word','AdminPageController@addWordToTranslate')->name('addWordToTranslate');
Route::post('/admin/lang/word/edit','AdminPageController@editTranslatedWord')->name('editTranslatedWord');
Route::post('/admin/lang/word/update','AdminPageController@editWord')->name('editWord');
Route::post('/admin/lang/add','AdminPageController@addLanguage')->name('addLanguage');
Route::get('/admin/lang/get','AdminPageController@getTranslated')->name('getTranslated');
Route::post('/admin/lang/edit/word','AdminPageController@editNotTranslatedWord')->name('editNotTranslatedWord');
Route::post('/admin/lang/edit/language','AdminPageController@editLanguage')->name('editLanguage');
/*video*/
Route::get("video",function(){
	return view("videoupload");
});

Route::get("/admin/image",'AdminPageController@testPage');
Route::post('/admin/image','AdminPageController@testImage')->name('testImage');
