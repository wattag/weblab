<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum SubmissionStatusEnum: int implements HasLabel, HasColor
{
    case Pending = 1;
    case Accepted = 2;
    case Rejected = 3;

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Pending => 'warning',
            self::Accepted => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return match($this) {
            self::Pending => 'Рассматривается',
            self::Accepted => 'Принято',
            self::Rejected => 'Отменено',
        };
    }
}
