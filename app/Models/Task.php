<?php

namespace App\Models;

use App\Enums\TaskSubmissionTypeEnum;
use App\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'type',
        'content',
        'deadline_at',
        'group_id',
        'submission_type',
        'discipline_id',
        'teacher_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => TaskTypeEnum::class,
            'submission_type' => TaskSubmissionTypeEnum::class,
            'deadline_at' => 'datetime',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
