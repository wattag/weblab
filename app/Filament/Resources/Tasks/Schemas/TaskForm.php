<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskSubmissionTypeEnum;
use App\Enums\TaskTypeEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('teacher_id')
                    ->default(auth()->id()),

                TextInput::make('title')
                    ->label('Название задания/лекции')
                    ->required()
                    ->maxLength(255),

                Select::make('discipline_id')
                    ->label('Дисциплина')
                    ->relationship('discipline', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('type')
                    ->label('Тип материала')
                    ->options([
                        'Теоретические материалы' => [
                            TaskTypeEnum::Theory->value => TaskTypeEnum::Theory->getLabel(),
                            TaskTypeEnum::Manual->value => TaskTypeEnum::Manual->getLabel(),
                        ],
                        'Практические работы' => [
                            TaskTypeEnum::Practice->value => TaskTypeEnum::Practice->getLabel(),
                            TaskTypeEnum::Lab->value => TaskTypeEnum::Lab->getLabel(),
                            TaskTypeEnum::Assignment->value => TaskTypeEnum::Assignment->getLabel(),
                        ],
                    ])
                    ->required()
                    ->live(),
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
                        Select::make('submission_type')
                            ->label('Что должен сдать студент?')
                            ->options(TaskSubmissionTypeEnum::class)
                            ->enum(TaskSubmissionTypeEnum::class)
                            ->visible(fn (Get $get) => in_array((int)$get('type'), [TaskTypeEnum::Practice->value, TaskTypeEnum::Lab->value, TaskTypeEnum::Assignment->value], true))
                            ->required(fn (Get $get) => in_array((int)$get('type'), [TaskTypeEnum::Practice->value, TaskTypeEnum::Lab->value, TaskTypeEnum::Assignment->value], true))
                            ->default(TaskSubmissionTypeEnum::Link->value)
                            ->default(TaskSubmissionTypeEnum::Link->value),

                        MarkdownEditor::make('content')
                            ->label('Текст лекции или задания')
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull()
            ]);
    }
}
