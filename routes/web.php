<?php

Route::get('/', 'HomeController@index');
Route::post('/reports/store', 'HomeController@store')->name('reports.store');
Route::view('/why', 'why')->name('why');
Route::get('/email', function () {
    return (new App\Mail\WeeklyReport())->render();
});
