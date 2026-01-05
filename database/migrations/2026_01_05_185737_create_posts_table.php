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
            $table->string('uuid', 64)->unique();
            $table->string('slug', 255)->index();

            // Relationships
            // BEST PRACTICE: Use nullable() instead of default(0) for optional relationships
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('parent_id')->default(null);

            // Flags & Status
            $table->boolean('is_featured')->default(0)->index();
            $table->string('post_type', 20)->default('article')->index();
            $table->string('status', 50)->default('draft')->index();
            $table->string('visibility', 50)->default('public')->index();
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

            // Performance Indexes
            // Composite index for common filtering (e.g., "Show me Public, Featured prompts")
            $table->index(['status', 'visibility', 'post_type', 'is_featured', 'slug']);

            $table->unique(['project_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
