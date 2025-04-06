<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_like'); // true = like, false = dislike
            $table->timestamps();

            $table->unique(['article_id', 'user_id']); // Користувач може поставити лише 1 лайк/дизлайк
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_likes');
    }
};
