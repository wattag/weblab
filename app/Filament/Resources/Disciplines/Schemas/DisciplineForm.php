<?php

namespace App\Filament\Resources\Disciplines\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DisciplineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Наименование дисциплины'),
            ]);
    }
}
