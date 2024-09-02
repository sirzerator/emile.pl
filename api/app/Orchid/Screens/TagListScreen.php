<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\TagTableLayout;
use App\Models\Tag;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TagListScreen extends Screen
{
    public function query(): iterable {
        return [
            'tags' => Tag::filters()->defaultSort('title', 'asc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.tag.name', 2);
    }

    public function description(): ?string {
        return _('models.tag.description.all');
    }

    public function commandBar(): iterable {
        return [
            Link::make(_('models.tag.actions.add'))
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
