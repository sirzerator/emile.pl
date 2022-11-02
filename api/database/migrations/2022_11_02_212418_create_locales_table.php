<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
        });
    }

    public function down() {
        Schema::dropIfExists('locales');
    }
};
