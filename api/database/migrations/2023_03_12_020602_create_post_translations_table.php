<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('post_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('translation_id');
            $table->boolean('post_is_source')->default(false);
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('translation_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->unique(['post_id', 'translation_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('post_translation');
    }
};
