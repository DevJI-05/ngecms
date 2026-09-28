<?php

namespace App\Support;

use App\Models\Inquiry;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryXlsxExporter
{
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

    public static function streamDownload(): StreamedResponse
    {
        $fileName = 'inquiries-'.now()->format('Y-m-d-His').'.xlsx';

        return response()->streamDownload(function () use ($fileName): void {
            $writer = new Writer;
            $writer->openToBrowser($fileName);
            $writer->addRow(Row::fromValues(self::HEADERS));

            Inquiry::query()->latest()->lazy()->each(function (Inquiry $inquiry) use ($writer): void {
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
            });

            $writer->close();
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }
}
