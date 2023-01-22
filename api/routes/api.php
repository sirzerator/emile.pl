<?php

use Illuminate\Support\Facades\Route;

Route::get('categories', 'App\Http\Controllers\CategoryController@index');
Route::get('categories/{id}', 'App\Http\Controllers\CategoryController@retrieve');

Route::get('posts', 'App\Http\Controllers\PostController@index');
Route::get('posts/{id}', 'App\Http\Controllers\PostController@retrieve');

Route::get('tags', 'App\Http\Controllers\TagController@index');
Route::get('tags/{id}', 'App\Http\Controllers\TagController@retrieve');
