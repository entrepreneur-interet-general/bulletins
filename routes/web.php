<?php

Route::get('/', 'HomeController@index');
Route::post('/reports/store', 'HomeController@store');
