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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->string('slug', 255);
            $table->string('content_type', 50)->default('widget');
            $table->string('lang', 10)->default('en');
            $table->string('status', 20)->default('draft');
            $table->string('has_icon', 255)->nullable();
            $table->integer('position')->default(0);
            $table->string('title', 255);
            $table->longText('content')->nullable();
            $table->longText('footer')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['project_id', 'slug', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
