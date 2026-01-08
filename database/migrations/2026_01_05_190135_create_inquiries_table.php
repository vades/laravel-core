<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();

            // 1. Context
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            // If the person filling the form is already logged in, link them.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // 2. Status Flags
            // Using 'string' status is often better than multiple booleans for workflow
            // (e.g., 'new', 'read', 'replied', 'spam', 'archived')
            // But if you prefer booleans, keep them:
            $table->boolean('is_read')->default(false);
            $table->boolean('is_spam')->default(false);
            $table->boolean('is_archived')->default(false);

            // 3. Sender Info
            $table->string('name', 255);
            $table->string('email', 255);

            // 4. Message Content
            $table->string('subject', 255)->nullable(); // Missing in original
            $table->text('message');

            // 5. Technical / Security / GDPR
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable(); // Critical for spam detection
            $table->timestamp('terms_accepted_at')->nullable(); // GDPR requirement

            $table->json('metadata')->nullable(); // For custom fields

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_read', 'is_spam', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
