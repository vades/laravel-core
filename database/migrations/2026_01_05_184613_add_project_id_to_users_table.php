<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // We use 'after' to position columns logically, though not strictly required by SQL
            $table->foreignId('project_id')
                //->nullable() // Nullable initially to handle existing users, remove if fresh DB
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('role', 50)->default('user')->index()->after('password');
            $table->string('account_type', 50)->default('free')->index()->after('role');
            $table->json('metadata')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn(['project_id', 'role', 'account_type', 'metadata']);
        });
    }
};
