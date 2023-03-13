<?php

namespace App\Models\Pivots;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTranslation extends Pivot
{
    protected static function booted(): void {
        static::created(function (PostTranslation $translation) {
            if ($translation->inverse()->exists()) {
                return;
            }

            $inverse = new PostTranslation();
            $inverse->translation_id = $translation->post_id;
            $inverse->post_id = $translation->translation_id;
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

    public function inverse() {
        return $this->translation->translation();
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function translation() {
        return $this->belongsTo(Post::class, 'translation_id');
    }
}
