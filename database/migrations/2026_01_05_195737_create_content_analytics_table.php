<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_analytics', function (Blueprint $table) {
            $table->id();

            // Link to the content
            $table->foreignId('content_id')
                ->constrained('contents')
                ->cascadeOnDelete();

            // Denormalized project_id for fast aggregate stats
            // (e.g., "Sum all views for Project X" without joining contents table)
            $table->foreignId('project_id');

            // Counters
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('unique_views')->default(0);
            $table->unsignedBigInteger('downloads')->default(0); // Useful if you have PDFs/Resources

            // Timestamps for "Trending" logic
            // "last_viewed_at" helps identify "zombie" contents that get no traffic
            $table->timestamp('last_viewed_at')->nullable();

            // Flexible storage for specific analytics
            // (e.g., {"desktop": 50, "mobile": 20, "referrers": ["google", "twitter"]})
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Ensure one analytics record per content
            $table->unique('content_id');

            $table->index(['project_id', 'views', 'last_viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_analytics');
    }
};
