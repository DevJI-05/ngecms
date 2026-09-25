<?php

namespace App\Filament\Resources\PortfolioProjects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PortfolioProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Project Name')
                    ->weight('semibold')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('cat')
                    ->label('Category')
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'done' ? 'success' : 'warning')
                    ->formatStateUsing(fn (string $state) => $state === 'done' ? 'Completed' : 'Ongoing'),
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->toggleable(),
                TextColumn::make('client')
                    ->label('Client')
                    ->toggleable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('cat')
                    ->label('Category')
                    ->options([
                        'pipeline' => 'Gas Pipeline',
                        'cng' => 'CNG',
                        'maintenance' => 'Maintenance',
                        'engineering' => 'Engineering',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'done' => 'Completed',
                        'ongoing' => 'Ongoing',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No projects yet')
            ->emptyStateDescription('Add a portfolio project to showcase it on the website.')
            ->emptyStateIcon(Heroicon::OutlinedFolderOpen);
    }
}
