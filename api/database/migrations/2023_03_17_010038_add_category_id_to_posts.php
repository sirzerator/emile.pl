<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->default(null);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');
        });
    }

    public function down() {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeignIdFor(Category::class, 'category_id');
            $table->dropColumn('category_id');
        });
    }
};
