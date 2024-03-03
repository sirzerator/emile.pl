<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

/**
 * Class ParagraphField.
 *
 * @method ParagraphField name(string $value = '')
 */
class ParagraphField extends Field
{
    protected $view = 'fields.paragraph_field';

    protected $attributes = [
        'name' => '',
    ];

    protected $inlineAttributes = [];
}
