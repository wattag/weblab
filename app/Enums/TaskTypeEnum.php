<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TaskTypeEnum: int implements HasColor, HasLabel
{
    case Theory = 1;
    case Practice = 2;

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Theory => 'success',
            self::Practice => 'warning',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return match($this) {
            self::Theory => 'Теория',
            self::Practice => 'Практика',
        };
    }
}
