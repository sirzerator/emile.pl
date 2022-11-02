<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public function query(): iterable {
        return [];
    }

    public function name(): ?string {
        return 'emile.pl';
    }

    public function description(): ?string {
        return "Site personnel d'Émile";
    }

    public function commandBar(): iterable {
        return [
            Link::make('Website')
                ->href('https://emile.pl')
                ->target('_blank')
                ->icon('globe-alt'),

            Link::make('GitHub')
                ->href('https://github.com/sirzerator/emile.pl')
                ->target('_blank')
                ->icon('social-github'),
        ];
    }

    public function layout(): iterable {
        return [];
    }
}
