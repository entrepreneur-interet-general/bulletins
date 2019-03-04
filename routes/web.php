<?php

Route::get('/', 'HomeController@index');
Route::post('/reports/store', 'HomeController@store')->name('reports.store');
Route::get('/email', function () {
    return (new App\Mail\WeeklyReport())->render();
});
