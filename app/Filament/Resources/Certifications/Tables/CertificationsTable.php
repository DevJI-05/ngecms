<?php

namespace App\Filament\Resources\Certifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CertificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->label('Certificate Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('issuer')
                    ->label('Issuer')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('valid_text')
                    ->label('Validity'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No certifications yet')
            ->emptyStateDescription('Add a certification or license held by the company.')
            ->emptyStateIcon(Heroicon::OutlinedDocumentCheck);
    }
}
