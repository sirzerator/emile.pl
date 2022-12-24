<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CategoryTableLayout;
use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class CategoryListScreen extends Screen
{
    public function query(): iterable {
        return [
            'categories' => Category::paginate(),
        ];
    }

    public function name(): ?string {
        return 'Categories';
    }

    public function description(): ?string {
        return 'All categories';
    }

    public function commandBar(): iterable {
        return [
            Link::make('Add')
                ->icon('plus')
                ->route('platform.category.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            CategoryTableLayout::class,
        ];
    }
}
