<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum UserRoleEnum: int implements HasColor, HasLabel
{
    case Teacher = 1;
    case Student = 2;

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Teacher => 'success',
            self::Student => 'warning',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Teacher => 'Преподаватель',
            self::Student => 'Студент',
        };
    }
}
