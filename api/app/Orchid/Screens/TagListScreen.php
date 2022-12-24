<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\TagTableLayout;
use App\Models\Tag;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class TagListScreen extends Screen
{
    public function query(): iterable {
        return [
            'tags' => Tag::paginate(),
        ];
    }

    public function name(): ?string {
        return 'Tags';
    }

    public function description(): ?string {
        return 'All tags';
    }

    public function commandBar(): iterable {
        return [
            Link::make('Add')
                ->icon('plus')
                ->route('platform.tag.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            TagTableLayout::class,
        ];
    }
}
