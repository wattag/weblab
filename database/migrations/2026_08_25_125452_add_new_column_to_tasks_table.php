<?php

use App\Enums\TaskSubmissionTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', static function (Blueprint $table) {
            $table->unsignedTinyInteger('submission_type')
                ->default(TaskSubmissionTypeEnum::Link);
        });
    }

    public function down(): void
    {
        Schema::table('tasks', static function (Blueprint $table) {
            $table->dropColumn('submission_type');
        });
    }
};
