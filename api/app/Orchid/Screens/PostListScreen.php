<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\PostListLayout;
use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PostListScreen extends Screen
{
    public function query(): iterable {
        return [
            'posts' => Post::paginate(),
        ];
    }

    public function name(): ?string {
        return 'Blog posts';
    }

    public function description(): ?string {
        return 'All blog posts';
    }

    public function commandBar(): iterable {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.post.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            PostListLayout::class,
        ];
    }
}
