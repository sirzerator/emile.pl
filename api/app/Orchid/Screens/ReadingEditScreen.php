<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Reading\StoreRequest;
use App\Models\Genre;
use App\Models\Post;
use App\Models\Reading;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ReadingEditScreen extends Screen
{
    public $reading;

    public function query(Reading $reading): iterable {
        return [
            'reading' => $reading,
        ];
    }

    public function name(): ?string {
        return $this->reading->exists ? $this->reading->title : _c('models.reading.name', 1);
    }

    public function description(): ?string {
        return $this->reading->exists ? __('models.reading.description.edit') : __('models.reading.description.new');
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.reading.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->reading->exists),

            Button::make(__('models.reading.actions.add'))
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('storeOrUpdate')
                ->canSee(!$this->reading->exists),

            Button::make(__('models.reading.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('storeOrUpdate')
                ->canSee($this->reading->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::columns([
                Layout::rows([
                    Input::make('reading.title')
                        ->required()
                        ->title(__('models.reading.fields.title')),
                    Input::make('reading.slug')
                        ->title(__('models.reading.fields.slug'))
                        ->disabled(),
                    Input::make('reading.author')
                        ->required()
                        ->title(__('models.reading.fields.author')),
                    Picture::make('reading.cover_image_url'),
                ]),

                Layout::rows([
                    Relation::make('reading.genre_id')
                        ->allowEmpty()
                        ->fromModel(Genre::class, 'title')
                        ->disabled(!$this->reading->id)
                        ->applyScope('whereLocale', config('app.locale'))
                        ->title(_c('models.genre.name', 1)),

                    DateTimer::make('reading.finished_at')
                        ->title(__('models.reading.fields.finished_at')),

                    Relation::make('reading.post_id')
                        ->allowEmpty()
                        ->fromModel(Post::class, 'title')
                        ->applyScope('isBookReview')
                        ->title(__('models.reading.fields.post')),
                ]),
            ]),
        ];

        if ($this->reading->exists) {
            $layout[] = DeleteConfirmationModal::make($this->reading->title);
        }

        return $layout;
    }

    public function storeOrUpdate(Reading $reading, StoreRequest $request) {
        $reading->fill($request->get('reading'))->save();

        if ($reading->wasRecentlyCreated) {
            Alert::info(__('models.reading.messages.created'));
        } else {
            Alert::info(__('models.reading.messages.updated'));
        }

        return redirect()->route('platform.reading.list');
    }

    public function remove(Reading $reading) {
        $reading->delete();

        Alert::info(__('models.reading.messages.deleted'));

        return redirect()->route('platform.reading.list');
    }
}
