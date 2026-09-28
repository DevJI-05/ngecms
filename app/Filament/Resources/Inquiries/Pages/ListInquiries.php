<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Filament\Resources\Inquiries\InquiryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cache;

class ListInquiries extends ListRecords
{
    protected static string $resource = InquiryResource::class;

    public ?string $inquiryExportId = null;

    public string $inquiryExportStatus = 'idle';

    public int $inquiryExportProcessed = 0;

    public int $inquiryExportTotal = 0;

    public ?string $inquiryExportError = null;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function resetInquiryExport(): void
    {
        $this->inquiryExportId = null;
        $this->inquiryExportStatus = 'idle';
        $this->inquiryExportProcessed = 0;
        $this->inquiryExportTotal = 0;
        $this->inquiryExportError = null;
    }

    public function pollInquiryExportProgress(): void
    {
        if (blank($this->inquiryExportId)) {
            return;
        }

        $progress = Cache::get("inquiry-export:{$this->inquiryExportId}");

        if (! $progress) {
            return;
        }

        $this->inquiryExportStatus = $progress['status'] ?? $this->inquiryExportStatus;
        $this->inquiryExportProcessed = $progress['processed'] ?? $this->inquiryExportProcessed;
        $this->inquiryExportTotal = $progress['total'] ?? $this->inquiryExportTotal;
        $this->inquiryExportError = $progress['error'] ?? null;
    }

    public function getInquiryExportDownloadUrl(): ?string
    {
        if (blank($this->inquiryExportId) || $this->inquiryExportStatus !== 'done') {
            return null;
        }

        return route('admin.inquiries.export.download', $this->inquiryExportId);
    }

    public function getInquiryExportPercentage(): int
    {
        if ($this->inquiryExportTotal <= 0) {
            return 0;
        }

        return (int) round(($this->inquiryExportProcessed / $this->inquiryExportTotal) * 100);
    }
}
