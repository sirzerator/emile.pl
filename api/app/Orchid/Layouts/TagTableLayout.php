<?php

namespace App\Orchid\Layouts;

use App\Models\Tag;
use App\Models\Locale;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TagTableLayout extends Table
{
    protected $target = 'tags';

    protected function columns(): iterable {
        return [
            TD::make('title', 'Title')
                ->render(function (Tag $tag) {
                    return Link::make($tag->title)
                        ->route('platform.tag.edit', $tag);
                }),
            TD::make('locale', 'Locale')
                ->render(function (Tag $tag) {
                    return Locale::title($tag->locale);
                }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Updated'),
        ];
    }
}
