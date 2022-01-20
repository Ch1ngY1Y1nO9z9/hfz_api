<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['get','post'],'/App/getBackground', 'api\PagesController@getBackground');
Route::match(['get','post'],'/Index/getIndexNews', 'api\PagesController@getIndexNews');
Route::match(['get','post'],'/Index/getIndexRank', 'api\PagesController@getIndexRank');
Route::match(['get','post'],'/Index/getIndexPrev', 'api\PagesController@getIndexPrev');
Route::match(['get','post'],'/Wrestlers/getWrestlers', 'api\PagesController@getWrestlers');
Route::match(['get','post'],'/Detail/getDetail/{name}', 'api\PagesController@getDetail');
Route::match(['get','post'],'/Detail/getFanbase/{name}', 'api\PagesController@getFanbase');
Route::match(['get','post'],'/Detail/getMatches/{name}', 'api\PagesController@getMatches');
Route::match(['get','post'],'/Detail/getWinLoseRate/{name}', 'api\PagesController@getWinLoseRate');
Route::match(['get','post'],'/News/getNews/{type}', 'api\PagesController@getNews');
Route::match(['get','post'],'/NewsContent/getNewsContent/{id}', 'api\PagesController@getNewsContent');
Route::match(['get','post'],'/Previous/getPrevious', 'api\PagesController@getPrevious');
Route::match(['get','post'],'/Previous/getMatchResult/{id}', 'api\PagesController@getMatchResult');
Route::match(['get','post'],'/Previous/getSongList/{id}/{game}', 'api\PagesController@getSongList');

Route::post('/addSong/{stream_id}/{game_id}/{link}', 'api\PagesController@addSong');

Route::get('/changeDB', 'api\PagesController@changeDB');

