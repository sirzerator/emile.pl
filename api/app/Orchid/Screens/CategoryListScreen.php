<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CategoryTableLayout;
use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CategoryListScreen extends Screen
{
    public function query(): iterable {
        return [
            'categories' => Category::filters()->defaultSort('title', 'asc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.category.name', 2);
    }

    public function description(): ?string {
        return __('models.category.description.all');
    }

    public function commandBar(): iterable {
        return [
            Link::make(_('models.category.actions.add'))
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
