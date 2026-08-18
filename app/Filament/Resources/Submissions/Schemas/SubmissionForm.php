<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enums\SubmissionStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Информация о сдаче')->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Студент')
                        ->disabled(),

                    Select::make('task_id')
                        ->relationship('task', 'title')
                        ->label('Задание')
                        ->disabled(),

                    TextInput::make('github_url')
                        ->label('Ссылка на GitHub')
                        ->url()
                        ->columnSpanFull(),
                ])->columns(),

                Section::make('Оценка преподавателя')->schema([
                    Select::make('status')
                        ->label('Статус проверки')
                        ->options(SubmissionStatusEnum::class)
                        ->enum(SubmissionStatusEnum::class)
                        ->required(),

                    TextInput::make('grade')
                        ->label('Оценка')
                        ->numeric()
                        ->nullable(),

                    Textarea::make('teacher_comment')
                        ->label('Комментарий')
                        ->rows(4)
                        ->columnSpanFull(),
                ])->columns(),
            ]);
    }
}
