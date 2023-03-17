<?php

namespace App\Models\Pivots;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTranslation extends Pivot
{
    protected static function booted(): void {
        static::updated(function (PostTranslation $translation) {
            if ($translation->wasChanged('post_is_source') && !!$translation->post_is_source) {
                static::where('translation_id', $translation->post_id)
                    ->orWhere('post_id', $translation->translation_id)
                    ->update([ 'post_is_source' => false ]);
            }
        });

        static::created(function (PostTranslation $translation) {
            if ($translation->inverseExists()) {
                return;
            }

            $inverse = new PostTranslation();
            $inverse->translation_id = $translation->post_id;
            $inverse->post_id = $translation->translation_id;
            $inverse->post_is_source = !$translation->post_is_source;
            $inverse->save();
        });

        static::deleted(function (PostTranslation $translation) {
            if ($postTranslation = PostTranslation::where('post_id', $translation->translation_id)
                ->where('translation_id', $translation->post_id)
                ->first()) {
                $postTranslation->delete();
            }
        });
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function translation() {
        return $this->belongsTo(Post::class, 'translation_id');
    }

    public function inverseExists() {
        return static::where('post_id', $this->translation_id)
            ->where('translation_id', $this->post_id)
            ->exists();
    }
}
