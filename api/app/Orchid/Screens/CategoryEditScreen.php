<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Category\CreateRequest;
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
        return $this->category->exists ? 'Edit category' : 'New category';
    }

    public function description(): ?string {
        return 'A single category';
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make('Remove')
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),

            Button::make('Add')
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Save')
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::rows([
                Input::make('category.title')
                    ->required()
                    ->title('Title'),
                Input::make('category.slug')
                    ->required()
                    ->title('Slug'),
                Select::make('category.locale')
                    ->options(Locale::asOptions())
                    ->title('Locale'),
            ]),
        ];

        if ($this->category->exists) {
            $layout[] = DeleteConfirmationModal::make($this->category->title);
        }

        return $layout;
    }

    public function createOrUpdate(Category $category, CreateRequest $request) {
        $category->fill($request->get('category'))->save();

        Alert::info('You have successfully created a category.');

        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category) {
        $category->delete();

        Alert::info('You have successfully deleted the category.');

        return redirect()->route('platform.category.list');
    }
}
