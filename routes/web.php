<?php

Route::get('/', 'HomeController@index');
Route::post('/reports/store', 'ReportsController@store')->name('reports.store');
Route::get('/reports', 'ReportsController@choose')->name('reports.choose');
Route::get('/reports/{reports}', 'ReportsController@index')->name('reports.index');
Route::view('/about', 'about')->name('about');
Route::get('/email', function () {
    return (new App\Mail\WeeklyReport())->render();
});
