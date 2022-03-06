<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::match(['get','post'],'/Index/getIndexArts', 'api\PagesController@getIndexArts');
Route::match(['get','post'],'/Index/getIndexRank', 'api\PagesController@getIndexRank');
Route::match(['get','post'],'/Index/getIndexPrev', 'api\PagesController@getIndexPrev');
Route::match(['get','post'],'/Wrestlers/getWrestlers', 'api\PagesController@getWrestlers');
Route::match(['get','post'],'/Detail/getDetail/{name}', 'api\PagesController@getDetail');
Route::match(['get','post'],'/Detail/getFanbase/{name}', 'api\PagesController@getFanbase');
Route::match(['get','post'],'/Detail/getMatches/{name}', 'api\PagesController@getMatches');
Route::match(['get','post'],'/Detail/getWinLoseRate/{name}', 'api\PagesController@getWinLoseRate');
Route::match(['get','post'],'/Poll/getPollResult', 'api\PagesController@getPollResult');
Route::match(['get','post'],'/Arts/getArts/{type}', 'api\PagesController@getArts');
Route::match(['get','post'],'/Arts/getArtsContent/{id}', 'api\PagesController@getNewsContent');
Route::match(['get','post'],'/Previous/getPrevious', 'api\PagesController@getPrevious');
Route::match(['get','post'],'/Previous/getMatchResult/{id}', 'api\PagesController@getMatchResult');
Route::match(['get','post'],'/Previous/getSongList/{id}/{game}', 'api\PagesController@getSongList');


Route::post('/Index/contact', 'api\PagesController@ContactUs');

Route::post('/roll/{name}/{yubis}', 'api\PagesController@rollCards');

Route::post('/checkUserYubis/{name}', 'api\PagesController@checkYubis');

Route::post('/ColllectionBook/{name}', 'api\PagesController@colllectionBook');

Route::post('/getBettingRecord/{name}', 'api\PagesController@getBettingRecord');

Route::post('/Betting/{name}', 'api\PagesController@Betting');

Route::post('/addSong/{stream_id}/{game_id}/{link}', 'api\PagesController@addSong');

Route::post('/collectYubis/{name}/{matchId}', 'api\PagesController@collectYubis');

Route::get('/changeDB', 'api\PagesController@changeDB');

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
