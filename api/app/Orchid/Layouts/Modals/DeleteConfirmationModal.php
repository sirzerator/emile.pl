<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Modals;

use Orchid\Support\Facades\Layout;

class DeleteConfirmationModal
{
    public static function make(string $itemName, string $informationText = '') {
        return Layout::modal('deleteConfirmationModal', [
            Layout::rows([]),
        ])
            ->title("Are you sure you want to delete « $itemName » ?")
            ->applyButton('Yes')
            ->closeButton('Cancel');
    }
}
