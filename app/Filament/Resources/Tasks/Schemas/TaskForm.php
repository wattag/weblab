<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskTypeEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Название задания/лекции')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->label('Тип')
                    ->options(TaskTypeEnum::class)
                    ->enum(TaskTypeEnum::class)
                    ->required()
                    ->default(TaskTypeEnum::Theory),

                Select::make('group_id')
                    ->label('Группа')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Оставьте пустым, если задание для всех групп'),

                DateTimePicker::make('deadline_at')
                    ->label('Дедлайн')
                    ->nullable(),

                Section::make('Контент')
                    ->schema([
                        MarkdownEditor::make('content')
                            ->label('Текст лекции или задания')
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull()
            ]);
    }
}
