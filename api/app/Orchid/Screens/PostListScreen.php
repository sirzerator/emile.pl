<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\PostTableLayout;
use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class PostListScreen extends Screen
{
    public function query(): iterable {
        return [
            'posts' => Post::filters()->defaultSort('published_at', 'desc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.post.name', 2);
    }

    public function description(): ?string {
        return _('models.post.description.all');
    }

    public function commandBar(): iterable {
        return [
            Link::make(_('models.post.actions.add'))
                ->icon('plus')
                ->route('platform.post.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            PostTableLayout::class,
        ];
    }
}
