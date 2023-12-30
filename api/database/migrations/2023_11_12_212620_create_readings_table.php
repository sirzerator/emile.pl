<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('author');
            $table->unsignedBigInteger('genre_id')->nullable()->default(null);
            $table->text('comments_fr')->nullable()->default('');
            $table->text('comments_en')->nullable()->default('');
            $table->dateTime('finished_at')->default(null)->nullable();
            $table->string('cover_image_url')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres')
                ->onDelete('restrict');
        });
    }

    public function down() {
        Schema::dropIfExists('readings');
    }
};
