<?php

Route::get('/', 'HomeController@index');
Route::get('/login', 'HomeController@login')->name('login');
Route::post('/login', 'HomeController@authenticate')->name('login');
Route::post('/reports/store', 'ReportsController@store')->name('reports.store');
Route::get('/reports', 'ReportsController@choose')->name('reports.choose');
Route::get('/reports/{reports}', 'ReportsController@index')->name('reports.index')->middleware('logged_in');
Route::view('/about', 'about')->name('about');
Route::get('/email', function () {
    return (new App\Mail\WeeklyReport())->render();
});
