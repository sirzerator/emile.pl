<?php

namespace App\Orchid\Layouts;

use App\Models\Locale;
use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    protected function columns(): iterable {
        return [
            TD::make('title', 'Title')
                ->render(function (Post $post) {
                    return Link::make($post->title)
                        ->route('platform.post.edit', $post);
                }),
            TD::make('locale', 'Locale')
                ->render(function (Post $post) {
                    return Locale::title($post->locale);
                }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Updated'),
        ];
    }
}
