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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 64)->unique();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->bigInteger('parent_id')->default(null);
            $table->string('status', 50)->default('draft')->index();
            $table->string('visibility', 50)->default('public')->index();
            $table->string('category_type', 20)->default('post');
            $table->integer('position')->default(0);
            $table->unsignedBigInteger('views_count')->default(0);

            $table->string('slug');
            $table->string('lang', 10)->default('en');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'visibility', 'slug']);

            $table->unique(['project_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
