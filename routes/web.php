<?php

Route::get('/clear', function(){
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('storage:link');
    return 'all cache has been removed and reset appliation succussfuly!';
});

// Route::get('/', function(){
//     return view('pages.login');
// })->name('login');
Route::get('/', 'LoginController@getLoginPage')->name('login');
Route::post('/login', 'LoginController@index')->name('post.login');
Route::get('/get-onload-data', 'DashboardController@index')->name('settings.object');
Route::get('/get-onload-data', 'DashboardController@getOnLoadData')->name('getOnLoadData');
Route::get('/get-object', 'DashboardController@getObjects')->name('getObjects');
Route::get('/get-object-history', 'DashboardController@getObjectHistory')->name('getObjectHistory');
Route::get('/get-events-list', 'DashboardController@getEventsList')->name('getEventsList');
Route::get('/resolve-event', 'DashboardController@resolveEvent')->name('resolveEvent');
Route::get('/get-group-list', 'DashboardController@getGroupList')->name('getGroupList');
Route::post('/send-message', 'DashboardController@sendMessage')->name('sendMessage');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('admin')->namespace('Backend')->group(function (){

    Route::middleware(['admin'])->group(function () {

    });
});
