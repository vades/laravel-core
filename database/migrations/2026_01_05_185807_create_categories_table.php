<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();

            $table->string('status', 20)->default('draft');
            $table->string('visibility', 20)->default('public');
            $table->string('category_type', 20)->default('post');

            $table->integer('position')->default(0);
            $table->unsignedBigInteger('views_count')->default(0);

            $table->string('slug', 255);
            $table->string('lang', 10)->default('en');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Unique slug per project
            $table->unique(['project_id', 'slug']);

            // Optimized composite index
            $table->index(['project_id', 'status', 'visibility']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
