<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('readings', function (Blueprint $table) {
            $table->dropColumn('comments_fr');
            $table->dropColumn('comments_en');
        });
    }

    public function down() {
        Schema::table('readings', function (Blueprint $table) {
            $table->text('comments_fr')->nullable()->default('');
            $table->text('comments_en')->nullable()->default('');
        });
    }
};
