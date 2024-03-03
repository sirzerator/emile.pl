<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\ContactTableLayout;
use App\Models\Contact;
use Orchid\Screen\Screen;

class ContactListScreen extends Screen
{
    public function query(): iterable {
        return [
            'contacts' => Contact::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function name(): ?string {
        return _c('models.contact.name', 2);
    }

    public function description(): ?string {
        return __('models.contact.description.all');
    }

    public function layout(): iterable {
        return [
            ContactTableLayout::class,
        ];
    }
}
