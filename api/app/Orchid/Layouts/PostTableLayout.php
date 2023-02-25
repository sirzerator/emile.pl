<?php

namespace App\Orchid\Layouts;

use App\Models\Locale;
use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostTableLayout extends Table
{
    protected $target = 'posts';

    protected function columns(): iterable {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('title', 'Title')
                ->filter(Input::make())
                ->sort()
                ->render(function (Post $post) {
                    return Link::make($post->title)
                        ->route('platform.post.edit', $post);
                }),
            TD::make('locale', 'Locale')
                ->filter(Select::make('post.locale')->options(Locale::asOptions(withNull: true)))
                ->sort()
                ->render(function (Post $post) {
                    return Locale::title($post->locale);
                }),

            TD::make('published_at', 'Published')->sort(),
            TD::make('created_at', 'Created')->sort(),
            TD::make('updated_at', 'Updated')->sort(),
        ];
    }
}
