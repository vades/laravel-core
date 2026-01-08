<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            // Identifiers
            $table->id();
            $table->uuid('uuid')->unique();

            // Relationships
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The creator
            // Added: Author might differ from Creator (e.g., admin posted on behalf of someone)
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('contents')->nullOnDelete();

            // Core Classification
            $table->string('content_type', 50); // Index this for filtering types
            $table->string('status', 20)->default('draft'); // Index for quick draft/published checks
            $table->string('visibility', 20)->default('public');
            $table->string('lang', 10)->default('en');

            // Data Payload
            $table->string('slug', 255);
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->text('excerpt')->nullable(); // Renamed 'description' to 'excerpt' (standard CMS term)

            // Content
            // Suggestion: If relying on full-text search, MySQL/Postgres handle 'longText' differently.
            $table->longText('content')->nullable();

            // Flexible Data (Polymorphism)
            // Use this for: Product prices, Catalog SKUs, Page templates, External Links
            $table->json('metadata')->nullable();

            // Sorting & Display
            $table->integer('position')->default(0);
            $table->boolean('is_featured')->default(false);

            // REMOVED: views_count (Move to `content_analytics` table to prevent table locking)

            // Scheduling & Timestamps
            $table->timestamp('published_at')->nullable(); // Crucial for sorting feeds
            $table->timestamps();
            $table->softDeletes();

            // Constraints

            // 1. Unique slug strategy:
            // If you want same slug for different languages: include 'lang'
            // If you want unique slug across all languages: keep ['project_id', 'slug']
            $table->unique(['project_id', 'slug', 'lang']);

            // 2. Performance Indices
            // Optimized for: "Show me published articles for this project, newest first"
            $table->index(['project_id', 'content_type', 'status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
