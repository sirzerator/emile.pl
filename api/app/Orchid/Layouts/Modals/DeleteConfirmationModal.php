<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Modals;

use App\Orchid\Fields\ParagraphField;
use Orchid\Support\Facades\Layout;

class DeleteConfirmationModal
{
	public static function make(string $itemName, string $informationText = '') {
		return Layout::modal('deleteConfirmationModal', [
			Layout::rows([
				ParagraphField::make('deleteConfirmationModal_content')->name($itemName),
			]),
		])
			->title(__('Please confirm deletion'))
			->applyButton(__('ui.modal.yes'))
			->closeButton(__('ui.modal.cancel'));
	}
}
