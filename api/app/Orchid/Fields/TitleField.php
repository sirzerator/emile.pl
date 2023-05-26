<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

/**
 * Class TitleField.
 *
 * @method TitleField title(string $value = '')
 * @method TitleField level(int $value = 2)
 */
class TitleField extends Field
{
    protected $view = 'fields.title_field';

    protected $attributes = [
        'title' => '',
        'level' => 2,
    ];

    protected $inlineAttributes = [];
}
