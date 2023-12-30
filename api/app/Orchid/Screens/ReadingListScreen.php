<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\ReadingTableLayout;
use App\Models\Reading;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class ReadingListScreen extends Screen
{
    public function query(): iterable {
        return [
            'readings' => Reading::filters()->defaultSort('finished_at', 'desc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.reading.name', 2);
    }

    public function description(): ?string {
        return _('models.reading.description.all');
    }

    public function commandBar(): iterable {
        return [
            Link::make(_('models.reading.actions.add'))
                ->icon('plus')
                ->route('platform.reading.edit'),
        ];
    }

    public function layout(): iterable {
        return [
            ReadingTableLayout::class,
        ];
    }
}
