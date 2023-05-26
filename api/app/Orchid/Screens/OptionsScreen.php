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
                        ->title(__('models.option.title.bio'))
                        ->value($this->getOptionValueFor('bio', 'fr'))
                        ->rows(10),
                    Input::make('options.fr.about.job')
                        ->value($this->getOptionValueFor('job', 'fr'))
                        ->title(__('models.option.title.job')),
                    Input::make('options.fr.about.situationg')
                        ->value($this->getOptionValueFor('situation', 'fr'))
                        ->title(__('models.option.title.situation')),
                    Input::make('options.fr.about.aka')
                        ->value($this->getOptionValueFor('situation', 'fr'))
                        ->title(__('models.option.title.aka')),
                    Input::make('options.fr.about.email')
                        ->value($this->getOptionValueFor('email', 'fr'))
                        ->title(__('models.option.title.email')),
                    Input::make('options.fr.about.telephone')
                        ->value($this->getOptionValueFor('telephone', 'fr'))
                        ->title(__('models.option.title.telephone')),
                    Input::make('options.fr.about.education')
                        ->value($this->getOptionValueFor('education', 'fr'))
                        ->title(__('models.option.title.education')),
                    Select::make('options.fr.about.availability')
                        ->options([
                            'available' => 'Disponible',
                            'short_term' => 'Le mois prochain',
                            'medium_term' => 'Dans 3 mois',
                            'long_term' => 'Dans 6 mois',
                            'unavailable' => 'Non disponible',
                        ])
                        ->value($this->getOptionValueFor('availability', 'fr')),
                ]),

                Layout::rows([
                    TitleField::make('about')
                        ->title('About')
                        ->level(3),

                    Quill::make('options.en.about.bio')
                        ->title(__('models.option.title.bio'))
                        ->value($this->getOptionValueFor('bio', 'en'))
                        ->rows(10),
                    Input::make('options.en.about.job')
                        ->value($this->getOptionValueFor('job', 'en'))
                        ->title(__('models.option.title.job')),
                    Input::make('options.en.about.situationg')
                        ->value($this->getOptionValueFor('situation', 'en'))
                        ->title(__('models.option.title.situation')),
                    Input::make('options.en.about.aka')
                        ->value($this->getOptionValueFor('situation', 'en'))
                        ->title(__('models.option.title.aka')),
                    Input::make('options.en.about.email')
                        ->value($this->getOptionValueFor('email', 'en'))
                        ->title(__('models.option.title.email')),
                    Input::make('options.en.about.telephone')
                        ->value($this->getOptionValueFor('telephone', 'en'))
                        ->title(__('models.option.title.telephone')),
                    Input::make('options.en.about.education')
                        ->value($this->getOptionValueFor('education', 'en'))
                        ->title(__('models.option.title.education')),
                    Select::make('options.en.about.availability')
                        ->options([
                            'available' => 'Disponible',
                            'short_term' => 'Le mois prochain',
                            'medium_term' => 'Dans 3 mois',
                            'long_term' => 'Dans 6 mois',
                            'unavailable' => 'Non disponible',
                        ])
                        ->value($this->getOptionValueFor('availability', 'en')),
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

    protected function getOptionValueFor($slug, $locale): string {
        $option = $this->options->where('slug', $slug)->where('locale', $locale)->first();

        if (!$option) {
            return '';
        }

        return $option->value;
    }
}
