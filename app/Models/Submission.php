<?php

namespace App\Models;

use App\Enums\SubmissionStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $fillable = [
        'user_id',
        'task_id',
        'github_url',
        'status',
        'teacher_comment',
        'grade'
    ];

    protected function casts(): array
    {
        return [
            'status' => SubmissionStatusEnum::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
