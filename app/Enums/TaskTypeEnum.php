<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TaskTypeEnum: int implements HasColor, HasLabel
{
    case Theory = 1;
    case Manual = 2;

    case Practice = 3;
    case Lab = 4;
    case Assignment = 5;

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Theory     => 'success',
            self::Manual     => 'info',
            self::Practice   => 'warning',
            self::Lab        => 'primary',
            self::Assignment => 'gray',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return match($this) {
            self::Theory => 'Лекция',
            self::Manual => 'Инструкция',
            self::Practice => 'Практическая работа',
            self::Lab => 'Входной контроль',
            self::Assignment => 'Домашнее задание',
        };
    }

    public function isTheoryGroup(): bool
    {
        return in_array($this, [self::Theory, self::Manual]);
    }

    public function isPracticeGroup(): bool
    {
        return in_array($this, [self::Practice, self::Lab, self::Assignment]);
    }
}
