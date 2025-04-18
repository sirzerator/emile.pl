<?php

namespace App\Orchid\Screens;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Category;
use App\Models\Locale;
use App\Models\Post;
use App\Models\Tag;
use App\Orchid\Layouts\Modals\DeleteConfirmationModal;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

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
        $translationFields = $this->getTranslationFields();

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
                        ->allowEmpty()
                        ->fromModel(Category::class, 'title')
                        ->disabled(!$this->post->id)
                        ->applyScope('whereLocale', $this->post ? $this->post->locale : '')
                        ->title(__('models.post.fields.category')),

                    Relation::make('post.tags')
                        ->fromModel(Tag::class, 'title')
                        ->disabled(!$this->post->id)
                        ->applyScope('whereLocale', $this->post ? $this->post->locale : '')
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
                    ->rows(5),
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
        $post->fill($request->get('post'))->save();

        if ($translation = data_get($post, 'translation')) {
            $post->translations()->sync([
                $translation => [
                    'post_is_source' => data_get($post, 'translation_is_source'),
                ],
            ]);
        } elseif ($translations = data_get($post, 'translations')) {
            $post->translations()->sync($translations);
        }

        $tags = data_get($post, 'tags');
        $post->tags()->sync($tags);

        if ($post->wasRecentlyCreated) {
            Alert::info(__('models.post.messages.created'));
        } else {
            Alert::info(__('models.post.messages.updated'));
        }

        return redirect()->route('platform.post.list');
    }

    public function remove(Post $post) {
        $post->delete();

        Alert::info(__('models.post.messages.deleted'));

        return redirect()->route('platform.post.list');
    }

    private function getTranslationFields() {
        if (!$this->post->exists) {
            return [];
        }

        if ($this->post->translations->count() > 0 && $this->post->translations->first()->pivot->post_is_source) {
            return [
                Relation::make('post.translations.')
                    ->allowEmpty()
                    ->fromModel(Post::class, 'title')
                    ->multiple()
                    ->applyScope('withAvailableTranslations', $this->post->locale, $this->post->id)
                    ->title(__('models.post.fields.translations')),

                CheckBox::make('post.translation_is_source')
                    ->value(!!data_get($this->post->translation, 'post_is_source'))
                    ->title(__('models.post.fields.post_is_source'))
                    ->sendTrueOrFalse()
                    ->disabled(!!data_get($this->post->translation, 'post_is_source')),
            ];
        }

        return [
            Relation::make('post.translation')
                ->allowEmpty()
                ->fromModel(Post::class, 'title')
                ->applyScope('withAvailableTranslations', $this->post->locale, $this->post->id)
                ->title(__('models.post.fields.translation')),

            CheckBox::make('post.translation_is_source')
                ->value(!!data_get($this->post->translation, 'post_is_source'))
                ->title(__('models.post.fields.post_is_source'))
                ->sendTrueOrFalse()
                ->disabled(!!data_get($this->post->translation, 'post_is_source')),
        ];
    }
}
