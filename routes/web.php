<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@login')->name('login');
Route::post('/login', 'HomeController@authenticate')->name('login');
Route::post('/reports/store', 'ReportsController@store')->name('reports.store');
Route::get('/reports', 'ReportsController@choose')->name('reports.choose');
Route::get('/reports/week', 'ReportsController@weekIndex')->name('reports.week_index')->middleware('logged_in');
Route::get('/reports/{reports}', 'ReportsController@index')->name('reports.index')->middleware('logged_in');
Route::get('/dates', 'DatesController@index')->name('dates.index')->middleware('logged_in');
Route::get('/reports/{reports}/export', 'ReportsController@export')->name('reports.export')->middleware('logged_in');
Route::view('/about', 'about')->name('about');
Route::get('/email/{week?}', function ($week = null) {
    return (new App\Mail\WeeklyReport($week))->render();
})->name('email_report')->middleware('logged_in');
Route::get('/locale/{locale}', 'LanguagesController@setLocale')->name('setLocale');
