<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use App\Models\Locale;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryTableLayout extends Table
{
    protected $target = 'categories';

    protected function columns(): iterable {
        return [
            TD::make('title', 'Title')
                ->render(function (Category $category) {
                    return Link::make($category->title)
                        ->route('platform.category.edit', $category);
                }),
            TD::make('locale', 'Locale')
                ->render(function (Category $category) {
                    return Locale::title($category->locale);
                }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Updated'),
        ];
    }
}
