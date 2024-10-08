<?php

namespace App\Orchid\Layouts;

use App\Models\Tag;
use App\Models\Locale;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TagTableLayout extends Table
{
    protected $target = 'tags';

    protected function columns(): iterable {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('title', __('models.tag.fields.title'))
                ->filter(Input::make())
                ->sort()
                ->render(function (Tag $tag) {
                    return Link::make($tag->title)
                        ->route('platform.tag.edit', $tag);
                }),

            TD::make('locale', __('models.tag.fields.locale'))
                ->filter(Select::make('genre.locale')->options(Locale::asOptions(withNull: true)))
                ->sort()
                ->render(function (Tag $tag) {
                    return Locale::title($tag->locale);
                })
                ->width(100),

            TD::make('created_at', __('models.tag.fields.created_at'))
                ->render(fn (Tag $t) => $t->created_at)
                ->width(200),
            TD::make('updated_at', __('models.tag.fields.updated_at'))
                ->render(fn (Tag $t) => $t->updated_at)
                ->width(200),
        ];
    }
}
