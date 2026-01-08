<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('content_type', 20);
            $table->string('lang', 10)->default('en');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->string('name', 255);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['project_id', 'name', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
