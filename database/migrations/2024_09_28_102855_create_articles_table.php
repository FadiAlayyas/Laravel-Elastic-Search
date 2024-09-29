<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Author of the article
            $table->string('title');
            $table->string('slug')->unique(); // SEO-friendly URL
            $table->text('body');
            $table->text('excerpt')->nullable(); // Short summary of the article
            $table->json('tags')->nullable(); // Tags for categorization
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade'); // Optional category
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Article status
            $table->timestamp('published_at')->nullable(); // Publication date
            $table->boolean('is_featured')->default(false); // Whether the article is featured
            $table->integer('views_count')->default(0); // Number of views
            $table->string('thumbnail')->nullable(); // Thumbnail image URL
            $table->json('metadata')->nullable(); // Additional metadata (e.g., SEO keywords)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
