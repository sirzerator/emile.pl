<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Post\CreateRequest;
use App\Models\Category;
use App\Models\Locale;
use App\Models\Post;
use App\Models\Tag;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class PostEditScreen extends Screen
{
    public $post;

    public function query(Post $post): iterable {
        return [
            'post' => $post,
        ];
    }

    public function name(): ?string {
        return $this->post->exists ? 'Edit post' : 'New post';
    }

    public function description(): ?string {
        return 'A single blog post';
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make('Remove')
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->post->exists),

            Button::make('Add')
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->post->exists),

            Button::make('Save')
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->post->exists),
        ];
    }

    public function layout(): iterable {
        $layout = [
            Layout::columns([
                Layout::rows([
                    Input::make('post.title')
                        ->required()
                        ->title('Title'),
                    Input::make('post.slug')
                        ->required()
                        ->title('Slug'),

                    Picture::make('post.featured_image_url'),
                ]),

                Layout::rows([
                    Relation::make('post.category_id')
                        ->fromModel(Category::class, 'title')
                        ->title('Category'),

                    Relation::make('post.tags')
                        ->fromModel(Tag::class, 'title')
                        ->multiple()
                        ->title('Tags'),

                    DateTimer::make('post.published_at')
                        ->title('Published')->enableTime(true),

                    Select::make('post.locale')
                        ->options(Locale::asOptions())
                        ->title('Locale'),

                    Relation::make('translations')
                        ->disabled(!$this->post->exists)
                        ->fromModel(Post::class, 'title')
                        ->applyScope('whereNotId', $this->post->id)
                        ->applyScope('whereNotLocale', $this->post->locale)
                        ->multiple()
                        ->title('Translations'),
                ]),
            ]),

            Layout::rows([
                TextArea::make('post.intro')
                    ->required()
                    ->title('Introduction')
                    ->rows(3),
                Quill::make('post.content')
                    ->required()
                    ->title('Content'),
            ]),
        ];

        if ($this->post->exists) {
            $layout[] = DeleteConfirmationModal::make($this->post->title);
        }

        return $layout;
    }

    public function createOrUpdate(Post $post, CreateRequest $request) {
        $post->fill($request->get('post'))->save();

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.post.list');
    }

    public function remove(Post $post) {
        $post->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.post.list');
    }
}
