<?php

namespace App\Orchid\Screens;

use App\Models\Contact;
use App\Models\Locale;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ContactEditScreen extends Screen
{
    public $contact;

    public function query(contact $contact): iterable {
        return [
            'contact' => $contact,
        ];
    }

    public function name(): ?string {
        return join(' ', [_c('models.contact.name', 1), __('from'), $this->contact->email]);
    }

    public function description(): ?string {
        return join(' ', [
            __('Sent'),
            $this->contact->created_at->translatedFormat('j F Y'),
            __('at'),
            $this->contact->created_at->translatedFormat('H:i'),
        ]);
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.contact.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->contact->exists),

            Button::make(__('models.contact.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('storeOrUpdate')
                ->canSee($this->contact->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::rows([
                Input::make('contact.name')
                    ->required()
                    ->disabled()
                    ->title(__('models.contact.fields.name')),

                Input::make('contact.email')
                    ->required()
                    ->disabled()
                    ->title(__('models.contact.fields.email')),

                TextArea::make('contact.message')
                    ->required()
                    ->disabled()
                    ->title(__('models.contact.fields.message'))
                    ->rows(5),


                Select::make('contact.locale')
                    ->options(Locale::asOptions())
                    ->disabled()
                    ->title(__('models.contact.fields.locale')),
            ]),
        ];

        if ($this->contact->exists) {
            $layout[] = DeleteConfirmationModal::make($this->contact->email);
        }

        return $layout;
    }

    public function remove(Contact $contact) {
        $contact->delete();

        Alert::info(__('models.contact.messages.deleted'));

        return redirect()->route('platform.contact.list');
    }
}
