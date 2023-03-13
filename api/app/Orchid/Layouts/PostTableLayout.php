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
                    return Link::make($post->title)->route('platform.post.edit', $post);
                }),

            TD::make('locale', 'Locale')
                ->filter(Select::make('post.locale')->options(Locale::asOptions(withNull: true)))
                ->sort()
                ->render(function (Post $post) {
                    return Locale::title($post->locale);
                }),

            TD::make('translations', 'Translations')
                ->render(function (Post $post) {
                    return $post->translations
                                ->map(fn ($t) => (string) Link::make($t->title)->route('platform.post.edit', $t))
                                ->join('');
                }),

            TD::make('published_at', 'Published')->sort(),
        ];
    }
}
