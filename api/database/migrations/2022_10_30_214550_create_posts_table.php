<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('locale', 2);
            $table->text('intro');
            $table->text('content');
            $table->dateTime('published_at')->default(null)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    Public function down() {
        Schema::dropIfExists('posts');
    }
};
