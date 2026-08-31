<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('discipline_group', function (Blueprint $table) {
            $table->foreignId('discipline_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();

            $table->primary(['discipline_id', 'group_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('discipline_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['discipline_id']);
            $table->dropColumn('discipline_id');
        });

        Schema::dropIfExists('discipline_group');
        Schema::dropIfExists('disciplines');
    }
};
