<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', static function (Blueprint $table) {
            $table->string('github_url')->nullable()->change();
            $table->string('file_path')->nullable()->after('github_url');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', static function (Blueprint $table) {
            $table->string('github_url')->nullable(false)->change();
            $table->dropColumn('file_path');
        });
    }
};
