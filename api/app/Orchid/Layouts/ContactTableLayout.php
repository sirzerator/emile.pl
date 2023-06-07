<?php

namespace App\Orchid\Layouts;

use App\Models\Contact;
use App\Models\Locale;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactTableLayout extends Table
{
    protected $target = 'contacts';

    protected function columns(): iterable {
        return [
            TD::make('name', __('models.contact.fields.name'))
                ->render(function (Contact $contact) {
                    return Link::make($contact->name)->route('platform.contact.edit', $contact);
                }),

            TD::make('email', __('models.contact.fields.email')),

            TD::make('locale', __('models.contact.fields.locale'))
                ->render(function (Contact $contact) {
                    return Locale::title($contact->locale);
                })
                ->width(100),

            TD::make('created_at', __('models.contact.fields.created_at'))->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Contact $contact) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('models.contact.actions.view'))
                            ->route('platform.contact.edit', $contact->id)
                            ->icon('eye'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('models.contact.actions.delete_confirmation', [$contact->email]))
                            ->method('remove', [
                                'id' => $contact->id,
                            ]),
                    ])),
        ];
    }
}
