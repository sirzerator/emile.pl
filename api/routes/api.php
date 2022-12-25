<?php

use Illuminate\Support\Facades\Route;

Route::get('tags', 'App\Http\Controllers\TagController@index');
Route::get('tags/{id}', 'App\Http\Controllers\TagController@retrieve');
