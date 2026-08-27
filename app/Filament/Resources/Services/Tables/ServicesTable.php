<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->label('Service Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('cat')
                    ->label('Category')
                    ->badge()
                    ->color('info'),
                TextColumn::make('tagline')
                    ->label('Tagline')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('foot_note')
                    ->label('Footnote')
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
                        'safety' => 'Safety & HSE',
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
            ->emptyStateHeading('No services yet')
            ->emptyStateDescription('Add a service to have it appear on the website.')
            ->emptyStateIcon(Heroicon::OutlinedBriefcase);
    }
}
