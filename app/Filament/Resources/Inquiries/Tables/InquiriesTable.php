<?php

namespace App\Filament\Resources\Inquiries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('perusahaan')
                    ->label('Company')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('layanan')
                    ->label('Service')
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('telepon')
                    ->label('Phone')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'baru' => 'danger',
                        'dihubungi' => 'warning',
                        'selesai' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'baru' => 'New',
                        'dihubungi' => 'Contacted',
                        'selesai' => 'Completed',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'New',
                        'dihubungi' => 'Contacted',
                        'selesai' => 'Completed',
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
            ->emptyStateHeading('No inquiries yet')
            ->emptyStateDescription('Submitted inquiries from the website will appear here.')
            ->emptyStateIcon(Heroicon::OutlinedEnvelope);
    }
}
