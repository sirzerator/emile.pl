<?php

namespace App\Orchid\Layouts;

use App\Models\Locale;
use App\Models\Reading;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReadingTableLayout extends Table
{
    protected $target = 'readings';

    protected function columns(): iterable {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('title', __('models.reading.fields.title'))
                ->filter(Input::make())
                ->sort()
                ->render(function (Reading $reading) {
                    return Link::make($reading->title)->route('platform.reading.edit', $reading);
                }),

            TD::make('author', __('models.reading.fields.author'))
                ->filter(Input::make())
                ->sort()
                ->render(function (Reading $reading) {
                    return Link::make($reading->author)->route('platform.reading.edit', $reading);
                }),

            TD::make('finished_at', __('models.reading.fields.finished_at'))->sort(),
        ];
    }
}
