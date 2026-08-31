<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enums\SubmissionStatusEnum;
use App\Models\Submission;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

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
                        ->label('Ссылка студента')
                        ->url()
                        ->disabled(),

                    TextEntry::make('no_file')
                        ->label('Прикрепленный файл')
                        ->state('Студент прислал только ссылку (файла нет)')
                        ->visible(fn (?Submission $record) => ! $record || ! $record->file_path),

                    Actions::make([
                        Action::make('download_file')
                            ->label('Скачать прикрепленный файл')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->url(fn (Submission $record) => Storage::url($record->file_path))
                            ->openUrlInNewTab()
                            ->visible(fn (?Submission $record) => $record && $record->file_path)
                    ])
                    ->columnSpanFull()
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
