<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
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

class CategoryEditScreen extends Screen
{
    public $category;

    public function query(Category $category): iterable {
        return [
            'category' => $category,
        ];
    }

    public function name(): ?string {
        return $this->category->exists ? $this->category->title : _c('models.category.name', 1);
    }

    public function description(): ?string {
        return $this->category->exists ? __('models.category.description.edit') : __('models.category.description.new');
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.category.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),

            Button::make(__('models.category.actions.add'))
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('storeOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make(__('models.category.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('storeOrUpdate')
                ->canSee($this->category->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::rows([
                Input::make('category.title')
                    ->required()
                    ->title(__('models.category.fields.title')),
                Input::make('category.slug')
                    ->title(__('models.category.fields.slug'))
                    ->disabled(),
                Select::make('category.locale')
                    ->options(Locale::asOptions())
                    ->title(__('models.category.fields.locale')),
            ]),
        ];

        if ($this->category->exists) {
            $layout[] = DeleteConfirmationModal::make($this->category->title);
        }

        return $layout;
    }

    public function storeOrUpdate(Category $category, StoreRequest $request) {
        $action = $category->id ? 'updated' : 'created';

        $category->fill($request->get('category'))->save();

        Alert::info(__("models.category.messages.$action"));

        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category) {
        $category->delete();

        Alert::info(__('models.category.messages.deleted'));

        return redirect()->route('platform.category.list');
    }
}
