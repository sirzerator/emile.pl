<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Tag\CreateRequest;
use App\Models\Tag;
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

class TagEditScreen extends Screen
{
    public $tag;

    public function query(Tag $tag): iterable {
        return [
            'tag' => $tag,
        ];
    }

    public function name(): ?string {
        return $this->tag->exists ? 'Edit tag' : 'New tag';
    }

    public function description(): ?string {
        return 'A single tag';
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make('Remove')
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->tag->exists),

            Button::make('Add')
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->tag->exists),

            Button::make('Save')
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->tag->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::rows([
                Input::make('tag.title')
                    ->required()
                    ->title('Title'),
                Input::make('tag.slug')
                    ->required()
                    ->title('Slug'),
                Select::make('tag.locale')
                    ->options(Locale::asOptions())
                    ->title('Locale'),
            ]),
        ];

        if ($this->tag->exists) {
            $layout[] = DeleteConfirmationModal::make($this->tag->title);
        }

        return $layout;
    }

    public function createOrUpdate(Tag $tag, CreateRequest $request) {
        $tag->fill($request->get('tag'))->save();

        Alert::info('You have successfully created a tag.');

        return redirect()->route('platform.tag.list');
    }

    public function remove(Tag $tag) {
        $tag->delete();

        Alert::info('You have successfully deleted the tag.');

        return redirect()->route('platform.tag.list');
    }
}
