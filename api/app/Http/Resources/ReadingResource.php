<?php

namespace App\Http\Resources;

class ReadingResource extends ApiResource
{
    protected function addItem($relation, &$output, &$resource) {
        if ($relation === 'post') {
            if (!$resource->post) {
                $output[$relation] = null;
                return;
            }

            $requestLocale = app('request')->get('locale') ?: config('app.locale');
            if ($resource->post->locale !== $requestLocale) {
                if ($translation = $resource->post->translations->where('locale', $requestLocale)->first()) {
                    $output[$relation] = $translation->getResourceInstance(
                        $this->getIncludedFieldsFor('post'),
                        $this->getExcludedFieldsFor('post'),
                        $resource->post->pivot,
                    );
                    return;
                }
            }
        }

        parent::addItem($relation, $output, $resource);
    }
}
