<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->text('value')->default('');
            $table->string('group')->nullable(true)->default(null)->index();
            $table->string('locale', 2);
            $table->timestamps();

            $table->unique(['slug', 'locale']);
        });
    }

    public function down() {
        Schema::dropIfExists('options');
    }
};
