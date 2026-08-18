<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')->schema([
                    TextInput::make('surname')
                        ->label('Фамилия')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('name')
                        ->label('Имя')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('patronymic')
                        ->label('Отчество')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Е-мейл')
                        ->required()
                        ->maxLength(255)
                ]),
                Section::make('Дополнительная информация')->schema([
                    TextInput::make('password')
                        ->label('Пароль')
                        ->password()
                        ->required(fn ($record) => $record === null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->helperText(fn ($record) => $record === null ? null : 'Оставьте пустым, если не хотите менять пароль')
                        ->maxLength(255),

                    Select::make('role')
                        ->label('Роль')
                        ->options(UserRoleEnum::class)
                        ->enum(UserRoleEnum::class)
                        ->required()
                        ->default(UserRoleEnum::Student),
                    Select::make('group_id')
                        ->label('Группа:')
                        ->relationship('group', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Оставьте пустым, если это преподаватель'),
                ])
            ]);
    }
}
