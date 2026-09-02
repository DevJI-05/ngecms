<?php

namespace App\Filament\Resources\CompanyValues\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class CompanyValuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(fn (?string $state): HtmlString => new HtmlString(
                        '<i class="ti '.e($state).'" style="font-size: 20px;"></i>',
                    )),
                TextColumn::make('name')
                    ->label('Value Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->toggleable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No company values yet')
            ->emptyStateDescription('Add a value to showcase what the company stands for.')
            ->emptyStateIcon(Heroicon::OutlinedHeart);
    }
}
