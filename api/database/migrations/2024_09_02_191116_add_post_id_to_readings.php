<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('readings', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable()->default(null);

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('readings', function (Blueprint $table) {
            $table->dropForeignIdFor(Post::class, 'post_id');
            $table->dropColumn('post_id');
        });
    }
};
