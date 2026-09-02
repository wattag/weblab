<?php

namespace App\Filament\Resources\Submissions\Tables;

use App\Enums\SubmissionStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable(),

                TextColumn::make('user.full_name')
                    ->label('Студент')
                    ->searchable(['name', 'surname'])
                    ->sortable(['name', 'surname']),

                TextColumn::make('user.group.name')
                    ->label('Группа'),

                TextColumn::make('task.title')
                    ->label('Задание')
                    ->limit(30),

                TextColumn::make('grade')
                    ->label('Оценка')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата сдачи')
                    ->dateTime('d.m.Y')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Дата изменения')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(SubmissionStatusEnum::class),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
