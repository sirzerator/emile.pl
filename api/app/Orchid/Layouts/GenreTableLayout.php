<?php

namespace App\Orchid\Layouts;

use App\Models\Genre;
use App\Models\Locale;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GenreTableLayout extends Table
{
    protected $target = 'genres';

    protected function columns(): iterable {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('title', __('models.genre.fields.title'))
                ->filter(Input::make())
                ->sort()
                ->render(function (Genre $genre) {
                    return Link::make($genre->title)
                        ->route('platform.genre.edit', $genre);
                }),

            TD::make('locale', __('models.genre.fields.locale'))
                ->filter(Select::make('genre.locale')->options(Locale::asOptions(withNull: true)))
                ->sort()
                ->render(function (Genre $genre) {
                    return Locale::title($genre->locale);
                })
                ->width(100),

            TD::make('created_at', __('models.genre.fields.created_at'))
                ->render(fn (Genre $g) => $g->created_at)
                ->width(200),
            TD::make('updated_at', __('models.genre.fields.updated_at'))
                ->render(fn (Genre $g) => $g->updated_at)
                ->width(200),
        ];
    }
}
