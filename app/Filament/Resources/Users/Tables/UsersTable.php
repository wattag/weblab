<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRoleEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('role')
                    ->label('Роль')
                    ->badge()
                    ->sortable(),
                TextColumn::make('surname')
                    ->label('Фамилия')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('patronymic')
                    ->label('Отчество')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Е-мейл')
                    ->searchable(),
                TextColumn::make('group.name')
                    ->label('Группа')
                    ->placeholder('Все группы'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y')
                    ->sortable(),
                ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Роль')
                    ->options(UserRoleEnum::class),
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
