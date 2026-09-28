<?php

namespace App\Jobs;

use App\Models\Inquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Throwable;

class ExportInquiriesJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var array<int, string>
     */
    private const HEADERS = [
        'Received', 'Name', 'Position', 'Email', 'Phone',
        'Company', 'Service', 'Service Detail', 'Estimate', 'Location', 'Message', 'Source', 'Status',
    ];

    /**
     * @var array<string, string>
     */
    private const STATUS_LABELS = [
        'baru' => 'New',
        'dihubungi' => 'Contacted',
        'selesai' => 'Completed',
    ];

    public function __construct(
        public string $exportId,
        public ?string $dateFrom = null,
        public ?string $dateUntil = null,
    ) {}

    public function handle(): void
    {
        $query = Inquiry::query()->latest();

        if (filled($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (filled($this->dateUntil)) {
            $query->whereDate('created_at', '<=', $this->dateUntil);
        }

        $total = (clone $query)->count();

        $this->putProgress([
            'status' => 'processing',
            'processed' => 0,
            'total' => $total,
        ]);

        $relativePath = "exports/inquiries-{$this->exportId}.xlsx";
        $absolutePath = Storage::disk('local')->path($relativePath);

        Storage::disk('local')->makeDirectory('exports');

        try {
            $writer = new Writer;
            $writer->openToFile($absolutePath);
            $writer->addRow(Row::fromValues(self::HEADERS));

            $processed = 0;

            foreach ($query->lazy(200) as $inquiry) {
                $writer->addRow(Row::fromValues([
                    $inquiry->created_at?->format('Y-m-d H:i'),
                    $inquiry->nama,
                    $inquiry->jabatan,
                    $inquiry->email,
                    $inquiry->telepon,
                    $inquiry->perusahaan,
                    $inquiry->layanan,
                    $inquiry->layanan_detail,
                    $inquiry->estimasi,
                    $inquiry->lokasi,
                    $inquiry->pesan,
                    $inquiry->sumber,
                    self::STATUS_LABELS[$inquiry->status] ?? $inquiry->status,
                ]));

                $processed++;

                if ($processed % 25 === 0) {
                    $this->putProgress([
                        'status' => 'processing',
                        'processed' => $processed,
                        'total' => $total,
                    ]);
                }
            }

            $writer->close();

            $this->putProgress([
                'status' => 'done',
                'processed' => $total,
                'total' => $total,
                'file' => $relativePath,
            ]);
        } catch (Throwable $exception) {
            $this->putProgress([
                'status' => 'failed',
                'processed' => 0,
                'total' => $total,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function putProgress(array $data): void
    {
        Cache::put(
            "inquiry-export:{$this->exportId}",
            [...Cache::get("inquiry-export:{$this->exportId}", []), ...$data],
            now()->addHour(),
        );
    }
}
