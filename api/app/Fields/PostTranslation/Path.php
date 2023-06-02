<?php

namespace App\Fields\PostTranslation;

use App\Fields\ComputedField;
use App\Fields\Field;

class Path extends Field implements ComputedField
{
    public static function compute(&$item): string {
        switch ($item->translation->locale) {
            case 'en':
                return "/blog/{$item->translation->id}/{$item->translation->slug}";
            case 'fr':
                return "/blogue/{$item->translation->id}/{$item->translation->slug}";
        }
    }
}
