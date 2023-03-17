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
        return $this->tag->exists ? $this->tag->title : _c('models.tag.name', 1);
    }

    public function description(): ?string {
        return $this->tag->exists ? __('models.tag.description.edit') : __('models.tag.description.new');
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.tag.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->tag->exists),

            Button::make(__('models.tag.actions.add'))
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->tag->exists),

            Button::make(__('models.tag.actions.save'))
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
                    ->title(__('models.tag.fields.title')),
                Input::make('tag.slug')
                    ->title(__('models.tag.fields.slug'))
                    ->disabled(),
                Select::make('tag.locale')
                    ->options(Locale::asOptions())
                    ->title(__('models.tag.fields.locale')),
            ]),
        ];

        if ($this->tag->exists) {
            $layout[] = DeleteConfirmationModal::make($this->tag->title);
        }

        return $layout;
    }

    public function createOrUpdate(Tag $tag, CreateRequest $request) {
        $action = $tag->id ? 'updated' : 'created';

        $tag->fill($request->get('tag'))->save();

        Alert::info(__("models.tag.messages.$action"));

        return redirect()->route('platform.tag.list');
    }

    public function remove(Tag $tag) {
        $tag->delete();

        Alert::info(__('models.tag.messages.deleted'));

        return redirect()->route('platform.tag.list');
    }
}
