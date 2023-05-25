<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Category;
use App\Models\Locale;
use App\Models\Post;
use App\Models\Tag;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\CheckBox;
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
        return $this->post->exists ? $this->post->title : _c('models.post.name', 1);
    }

    public function description(): ?string {
        return $this->post->exists ? __('models.post.description.edit') : __('models.post.description.new');
    }

    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('models.post.actions.delete'))
                ->modal('deleteConfirmationModal')
                ->type(Color::DANGER())
                ->icon('trash')
                ->method('remove')
                ->canSee($this->post->exists),

            Button::make(__('models.post.actions.add'))
                ->type(Color::PRIMARY())
                ->icon('check')
                ->method('storeOrUpdate')
                ->canSee(!$this->post->exists),

            Button::make(__('models.post.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('storeOrUpdate')
                ->canSee($this->post->exists),
        ];
    }

    public function layout(): iterable {
        $translationFields =  $this->post->exists ? [
            Relation::make('post.translation')
                ->allowEmpty()
                ->fromModel(Post::class, 'title')
                ->applyScope('whereNotId', $this->post->id)
                ->applyScope('whereNotLocale', $this->post->locale)
                ->title(__('models.post.fields.translation')),

            CheckBox::make('post.translation_is_source')
                ->value(!!data_get($this->post->translation, 'post_is_source'))
                ->title(__('models.post.fields.post_is_source'))
                ->sendTrueOrFalse()
                ->disabled(!!data_get($this->post->translation, 'post_is_source')),
        ] : [];

        $layout = [
            Layout::columns([
                Layout::rows([
                    Input::make('post.title')
                        ->required()
                        ->title(__('models.post.fields.title')),
                    Input::make('post.slug')
                        ->title(__('models.post.fields.slug'))
                        ->disabled(),
                    Picture::make('post.featured_image_url'),
                ]),

                Layout::rows([
                    Relation::make('post.category_id')
                        ->fromModel(Category::class, 'title')
                        ->title(__('models.post.fields.category')),

                    Relation::make('post.tags')
                        ->fromModel(Tag::class, 'title')
                        ->multiple()
                        ->title(__('models.post.fields.tags')),

                    DateTimer::make('post.published_at')
                        ->title(__('models.post.fields.published_at'))
                        ->enableTime(true),

                    Select::make('post.locale')
                        ->options(Locale::asOptions())
                        ->title(__('models.post.fields.locale')),

                    ...$translationFields,
                ]),
            ]),

            Layout::rows([
                TextArea::make('post.intro')
                    ->required()
                    ->title(__('models.post.fields.intro'))
                    ->rows(3),
                Quill::make('post.content')
                    ->required()
                    ->title(__('models.post.fields.content')),
            ]),
        ];

        if ($this->post->exists) {
            $layout[] = DeleteConfirmationModal::make($this->post->title);
        }

        return $layout;
    }

    public function storeOrUpdate(Post $post, StoreRequest $request) {
        $data = $request->get('post');

        $post->fill($data)->save();

        $translation = data_get($data, 'translation');
        if ($translation) {
            $post->translations()->sync([
                $translation => [
                    'post_is_source' => data_get($data, 'translation_is_source'),
                ],
            ]);
        } else {
            $post->translations()->sync(null);
        }

        $tags = data_get($data, 'tags');
        $post->tags()->sync($tags);

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.post.list');
    }

    public function remove(Post $post) {
        $post->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.post.list');
    }
}
