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
            TD::make('title', __('models.category.fields.title'))
                ->render(function (Category $category) {
                    return Link::make($category->title)
                        ->route('platform.category.edit', $category);
                }),

            TD::make('locale', __('models.category.fields.locale'))
                ->render(function (Category $category) {
                    return Locale::title($category->locale);
                })
                ->width(100),

            TD::make('created_at', __('models.category.fields.created_at'))
                ->render(fn (Category $t) => $t->created_at)
                ->width(200),
            TD::make('updated_at', __('models.category.fields.updated_at'))
                ->render(fn (Category $t) => $t->updated_at)
                ->width(200),
        ];
    }
}
