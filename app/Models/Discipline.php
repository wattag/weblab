<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discipline extends Model
{
    protected $fillable = ['name'];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
