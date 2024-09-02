<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Genre\StoreRequest;
use App\Models\Genre;
use App\Models\Locale;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class GenreEditScreen extends Screen
{
    public $genre;

    public function query(Genre $genre): iterable {
        return [
            'genre' => $genre,
        ];
    }

    public function name(): ?string {
        return $this->genre->exists ? $this->genre->title : _c('models.genre.name', 1);
    }

    public function description(): ?string {
        return $this->genre->exists ? __('models.genre.description.edit') : __('models.genre.description.new');
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.genre.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->genre->exists),

            Button::make(__('models.genre.actions.add'))
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('storeOrUpdate')
                ->canSee(!$this->genre->exists),

            Button::make(__('models.genre.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('storeOrUpdate')
                ->canSee($this->genre->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::rows([
                Input::make('genre.title')
                    ->required()
                    ->title(__('models.genre.fields.title')),
                Select::make('genre.locale')
                    ->options(Locale::asOptions())
                    ->title(__('models.genre.fields.locale')),
            ]),
        ];

        if ($this->genre->exists) {
            $layout[] = DeleteConfirmationModal::make($this->genre->title);
        }

        return $layout;
    }

    public function storeOrUpdate(Genre $genre, StoreRequest $request) {
        $action = $genre->id ? 'updated' : 'created';

        $genre->fill($request->get('genre'))->save();

        Alert::info(__("models.genre.messages.$action"));

        return redirect()->route('platform.genre.list');
    }

    public function remove(Genre $genre) {
        $genre->delete();

        Alert::info(__('models.genre.messages.deleted'));

        return redirect()->route('platform.genre.list');
    }
}
