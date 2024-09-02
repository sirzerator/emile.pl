<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\GenreTableLayout;
use App\Models\Genre;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class GenreListScreen extends Screen
{
    public function query(): iterable {
        return [
            'genres' => Genre::filters()->defaultSort('title', 'asc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.genre.name', 2);
    }

    public function description(): ?string {
        return __('models.genre.description.all');
    }

    public function commandBar(): iterable {
        return [
            Link::make(_('models.genre.actions.add'))
                ->icon('plus')
                ->route('platform.genre.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            GenreTableLayout::class,
        ];
    }
}
