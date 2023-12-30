<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'emile.pl' => app()->version(),
    ];
});

Route::apiResources([
    'categories' => CategoryController::class,
    'genres' => GenreController::class,
    'options' => OptionController::class,
    'posts' => PostController::class,
    'readings' => ReadingController::class,
    'tags' => TagController::class,
]);

Route::post('contacts', [ContactController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::resource('contacts', CategoryController::class)->except([
        'create', 'edit', 'store',
    ]);
});

Route::get('/options/group/{group}', [OptionController::class, 'showGroup']);
