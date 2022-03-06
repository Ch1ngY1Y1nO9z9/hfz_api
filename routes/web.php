<?php

use Carbon\Carbon;
use App\Events\Test;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
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

Route::get('/', function () {
    return redirect('/admin');
});


Route::get('/broadcast' , function() {
    broadcast(new Test());
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {

    Route::get('/','HomeController@index');

    Route::middleware('role:admin')->group(function(){
        Route::get('seo', 'SeoController@index');
        Route::post('seo', 'SeoController@update');

        // Banner
        Route::get('banner','BannerController@index');
        Route::get('banner/edit/{id}', 'BannerController@edit');
        Route::post('banner/update/{id}', 'BannerController@update');

        // 最新消息
        Route::get('/news','NewsController@index');
        Route::get('news/create','NewsController@create');
        Route::get('news/edit/{id}', 'NewsController@edit');
        Route::post('news/store','NewsController@store');
        Route::post('news/update/{id}', 'NewsController@update');
        Route::post('news/delete/{id}', 'NewsController@delete');

        //聯絡我們管理
        Route::get('contact','ContactController@index');
        Route::get('contact/{id}','ContactController@show');
        Route::post('contact/delete/{id}','ContactController@delete');

        //檔案資料管理
        Route::get('profile','ProfilesController@index');
        Route::get('profile_data/edit/{id}', 'ProfilesController@edit_data');
        Route::post('profile_data/update/{id}', 'ProfilesController@update_data');

        // 短片管理
        Route::get('profile/{wrestler_id}/clips','ClipsController@index');
        Route::get('profile/{wrestler_id}/clips/create', 'ClipsController@create');
        Route::get('profile/{wrestler_id}/clips/edit/{id}', 'ClipsController@edit');
        Route::post('profile/clips/store', 'ClipsController@store');
        Route::post('profile/clips/update/{id}', 'ClipsController@update');
        Route::post('profile/clips/delete/{id}', 'ClipsController@delete');

        //排行榜
        Route::get('/rank','ProfilesController@rank_index');
        Route::post('/rank/update', 'ProfilesController@rank_update');
    });


    // 直播記錄管理
    Route::get('stream','StreamRecordsController@index');
    Route::get('stream/create', 'StreamRecordsController@create')->middleware('role:admin');
    Route::get('stream/edit/{id}', 'StreamRecordsController@edit');
    Route::post('stream/store', 'StreamRecordsController@store')->middleware('role:admin');
    Route::post('stream/update/{id}', 'StreamRecordsController@update');
    Route::post('stream/delete/{id}', 'StreamRecordsController@delete')->middleware('role:admin');

    // 比賽紀錄管理
    Route::get('stream/match_result/{stream_id}','MatchResultController@index');
    Route::get('stream/match_result/{stream_id}/create', 'MatchResultController@create');
    Route::get('stream/match_result/{stream_id}/edit/{id}', 'MatchResultController@edit');
    Route::post('stream/match_result/{stream_id}/store', 'MatchResultController@store');
    Route::post('stream/match_result/update/{id}', 'MatchResultController@update');
    Route::post('stream/match_result/delete/{id}', 'MatchResultController@delete');

    // 歌單管理
    Route::get('stream/song_list/{stream_id}','SongListController@index');
    Route::get('stream/song_list/{stream_id}/create', 'SongListController@create');
    Route::get('stream/song_list/edit/{id}', 'SongListController@edit');
    Route::post('stream/song_list/store', 'SongListController@store');
    Route::post('stream/song_list/update/{id}', 'SongListController@update');
    Route::post('stream/song_list/delete/{id}', 'SongListController@delete');

});
