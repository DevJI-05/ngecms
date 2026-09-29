<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Jobs\ExportInquiriesJob;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->headerActions([
                Action::make('export')
                    ->label('Export Excel')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->modalHeading('Export Inquiries')
                    ->modalSubmitActionLabel('Start Export')
                    ->modalSubmitAction(fn (ListInquiries $livewire): ?bool => $livewire->inquiryExportStatus === 'idle' ? null : false)
                    ->modalCancelActionLabel(fn (ListInquiries $livewire): string => $livewire->inquiryExportStatus === 'done' ? 'Close' : 'Cancel')
                    ->mountUsing(function (?Schema $schema, ListInquiries $livewire): void {
                        $livewire->resetInquiryExport();
                        $schema?->fill();
                    })
                    ->schema([
                        Radio::make('scope')
                            ->label('Data to export')
                            ->options([
                                'all' => 'All data',
                                'range' => 'Date range',
                            ])
                            ->default('all')
                            ->live()
                            ->inline()
                            ->disabled(fn (ListInquiries $livewire): bool => $livewire->inquiryExportStatus !== 'idle'),
                        DatePicker::make('dateFrom')
                            ->label('From date')
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('scope') === 'range')
                            ->required(fn (Get $get): bool => $get('scope') === 'range')
                            ->disabled(fn (ListInquiries $livewire): bool => $livewire->inquiryExportStatus !== 'idle'),
                        DatePicker::make('dateUntil')
                            ->label('Until date')
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('scope') === 'range')
                            ->required(fn (Get $get): bool => $get('scope') === 'range')
                            ->afterOrEqual('dateFrom')
                            ->disabled(fn (ListInquiries $livewire): bool => $livewire->inquiryExportStatus !== 'idle'),
                    ])
                    ->action(function (array $data, Action $action, ListInquiries $livewire): void {
                        if ($livewire->inquiryExportStatus === 'processing') {
                            $action->halt();
                        }

                        $exportId = (string) Str::uuid();

                        $livewire->inquiryExportId = $exportId;
                        $livewire->inquiryExportStatus = 'processing';
                        $livewire->inquiryExportProcessed = 0;
                        $livewire->inquiryExportTotal = 0;
                        $livewire->inquiryExportError = null;

                        ExportInquiriesJob::dispatchSync(
                            $exportId,
                            $data['scope'] === 'range' ? $data['dateFrom'] : null,
                            $data['scope'] === 'range' ? $data['dateUntil'] : null,
                        );

                        $action->halt();
                    })
                    ->modalContentFooter(fn (ListInquiries $livewire): View => view('filament.inquiries.export-progress', [
                        'status' => $livewire->inquiryExportStatus,
                        'processed' => $livewire->inquiryExportProcessed,
                        'total' => $livewire->inquiryExportTotal,
                        'percentage' => $livewire->getInquiryExportPercentage(),
                        'error' => $livewire->inquiryExportError,
                        'downloadUrl' => $livewire->getInquiryExportDownloadUrl(),
                    ])),
            ])
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
                    ->description(fn (Inquiry $record): ?string => $record->layanan_detail)
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
