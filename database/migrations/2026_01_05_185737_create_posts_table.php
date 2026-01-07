<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            // Identifiers
            $table->id();
            $table->uuid('uuid')->unique(); // Standard 36 chars
            $table->string('slug', 255);

            // Relationships
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('posts')->nullOnDelete();

            // Flags & Status
            $table->boolean('is_featured')->default(false);
            $table->string('post_type', 20)->default('article');
            $table->string('status', 20)->default('draft');
            $table->string('visibility', 20)->default('public')->index();
            $table->integer('position')->default(0);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->string('lang', 10)->default('en');

            // Data Payload
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->json('metadata')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Constraints & Performance
            // Unique slug per project (Multi-tenancy support)
            $table->unique(['project_id', 'slug']);

            // Composite index for fetching public posts within a project (Very common query)
            $table->index(['project_id', 'status', 'visibility', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
