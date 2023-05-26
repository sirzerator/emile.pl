<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    public function registerMainMenu(): array {
        return [
            Menu::make(_c('models.post.name', 2))
                ->icon('book-open')
                ->divider(true)
                ->route('platform.post.list'),


            Menu::make(_c('models.category.name', 2))
                ->icon('folder-alt')
                ->route('platform.category.list'),

            Menu::make(_c('models.tag.name', 2))
                ->icon('tag')
                ->divider(true)
                ->route('platform.tag.list'),

            Menu::make(_c('models.option.name', 2))
                ->icon('settings')
                ->route('platform.options.edit'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }
    public function registerProfileMenu(): array {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    public function registerPermissions(): array {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
