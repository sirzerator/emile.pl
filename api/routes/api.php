<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'emile.pl' => app()->version(),
    ];
});

Route::apiResources([
    'categories' => CategoryController::class,
    'options' => OptionController::class,
    'posts' => PostController::class,
    'tags' => TagController::class,
]);

Route::get('/options/group/{group}', [OptionController::class, 'showGroup']);
