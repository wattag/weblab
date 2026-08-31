<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskSubmissionTypeEnum: int implements HasColor, HasLabel
{
    case Link = 1;
    case File = 2;
    case Any = 3;

    public function getLabel(): string
    {
        return match($this) {
            self::Link => 'Только ссылка',
            self::File => 'Только файл',
            self::Any => 'Ссылка или Файл',
        };
    }

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Link => 'success',
            self::File => 'info',
            self::Any => 'warning',
        };
    }
}
