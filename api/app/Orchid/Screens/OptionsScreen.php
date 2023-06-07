<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Http\Requests\Option\MassUpdateRequest;
use App\Models\Option;
use App\Orchid\Fields\TitleField;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OptionsScreen extends Screen
{
    public $options;

    public function query(): iterable {
        return [
            'options' => Option::all(),
        ];
    }

    public function name(): ?string {
        return _c('models.option.name', 2);
    }

    public function description(): ?string {
        return "Configuration statique du site";
    }

    public function commandBar(): iterable {
        return [
            Button::make(__('models.post.actions.save'))
                ->type(Color::PRIMARY())
                ->icon('note')
                ->method('update'),
        ];
    }

    public function layout(): iterable {
        return [
            Layout::columns([
                Layout::rows([
                    TitleField::make('about')
                        ->title('À propos')
                        ->level(3),

                    Quill::make('options.fr.about.bio')
                        ->title(__('models.option.about.bio'))
                        ->value($this->getAboutOptionValueFor('bio', 'fr')),
                    Input::make('options.fr.about.job')
                        ->value($this->getAboutOptionValueFor('job', 'fr'))
                        ->title(__('models.option.about.job')),
                    Input::make('options.fr.about.situation')
                        ->value($this->getAboutOptionValueFor('situation', 'fr'))
                        ->title(__('models.option.about.situation')),
                    Input::make('options.fr.about.aka')
                        ->value($this->getAboutOptionValueFor('aka', 'fr'))
                        ->title(__('models.option.about.aka')),
                    Input::make('options.fr.about.email')
                        ->value($this->getAboutOptionValueFor('email', 'fr'))
                        ->title(__('models.option.about.email')),
                    Input::make('options.fr.about.telephone')
                        ->value($this->getAboutOptionValueFor('telephone', 'fr'))
                        ->title(__('models.option.about.telephone')),
                    Input::make('options.fr.about.education')
                        ->value($this->getAboutOptionValueFor('education', 'fr'))
                        ->title(__('models.option.about.education')),
                    Select::make('options.fr.about.availability')
                        ->options([
                            'available' => 'Disponible',
                            'short_term' => 'Le mois prochain',
                            'medium_term' => 'Dans 3 mois',
                            'long_term' => 'Dans 6 mois',
                            'unavailable' => 'Non disponible',
                        ])
                        ->value($this->getAboutOptionValueFor('availability', 'fr')),
                ]),

                Layout::rows([
                    TitleField::make('about')
                        ->title('About')
                        ->level(3),

                    Quill::make('options.en.about.bio')
                        ->title(__('models.option.about.bio'))
                        ->value($this->getAboutOptionValueFor('bio', 'en')),
                    Input::make('options.en.about.job')
                        ->value($this->getAboutOptionValueFor('job', 'en'))
                        ->title(__('models.option.about.job')),
                    Input::make('options.en.about.situation')
                        ->value($this->getAboutOptionValueFor('situation', 'en'))
                        ->title(__('models.option.about.situation')),
                    Input::make('options.en.about.aka')
                        ->value($this->getAboutOptionValueFor('aka', 'en'))
                        ->title(__('models.option.about.aka')),
                    Input::make('options.en.about.email')
                        ->value($this->getAboutOptionValueFor('email', 'en'))
                        ->title(__('models.option.about.email')),
                    Input::make('options.en.about.telephone')
                        ->value($this->getAboutOptionValueFor('telephone', 'en'))
                        ->title(__('models.option.about.telephone')),
                    Input::make('options.en.about.education')
                        ->value($this->getAboutOptionValueFor('education', 'en'))
                        ->title(__('models.option.about.education')),
                    Select::make('options.en.about.availability')
                        ->options([
                            'available' => 'Disponible',
                            'short_term' => 'Le mois prochain',
                            'medium_term' => 'Dans 3 mois',
                            'long_term' => 'Dans 6 mois',
                            'unavailable' => 'Non disponible',
                        ])
                        ->value($this->getAboutOptionValueFor('availability', 'en')),
                ]),
            ]),
            Layout::columns([
                Layout::rows([
                    TitleField::make('contact')
                        ->title('Contact (FR)')
                        ->level(3),

                    Quill::make('options.fr.contact.content')
                        ->title(__('models.option.contact.content'))
                        ->value($this->getOptionValueFor('content', 'fr', 'contact')),
                    Input::make('options.fr.contact.subtitle')
                        ->value($this->getOptionValueFor('subtitle', 'fr', 'contact'))
                        ->title(__('models.option.contact.subtitle')),
                ]),

                Layout::rows([
                    TitleField::make('about')
                        ->title('Contact (EN)')
                        ->level(3),

                    Quill::make('options.en.contact.content')
                        ->title(__('models.option.contact.content'))
                        ->value($this->getOptionValueFor('content', 'en', 'contact')),
                    Input::make('options.en.contact.subtitle')
                        ->value($this->getOptionValueFor('subtitle', 'en', 'contact'))
                        ->title(__('models.option.contact.subtitle')),
                ]),
            ]),
        ];
    }

    public function update(MassUpdateRequest $request) {
        $data = $request->getOptionsData();

        foreach ($data as $option) {
            Option::updateOrCreate([
                'locale' => $option['locale'],
                'slug' => $option['slug'],
            ], $option);
        }

        Alert::info('Successfully saved the site options.');

        return redirect()->route('platform.options.edit');
    }

    protected function getAboutOptionValueFor($slug, $locale): string {
        return $this->getOptionValueFor($slug, $locale, 'about');
    }

    protected function getOptionValueFor($slug, $locale, $group): string {
        $option = $this->options->where('slug', $slug)->where('locale', $locale)->first();

        if (!$option) {
            return '';
        }

        return $option->value;
    }
}
