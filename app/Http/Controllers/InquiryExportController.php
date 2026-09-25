<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $records = Inquiry::query()->latest()->get();

        $headers = [
            'Received', 'Name', 'Position', 'Email', 'Phone',
            'Company', 'Service', 'Estimate', 'Location', 'Message', 'Source', 'Status',
        ];

        $statusLabels = [
            'baru' => 'New',
            'dihubungi' => 'Contacted',
            'selesai' => 'Completed',
        ];

        return response()->streamDownload(function () use ($records, $headers, $statusLabels): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($records as $record) {
                fputcsv($handle, [
                    $record->created_at?->format('Y-m-d H:i'),
                    $record->nama,
                    $record->jabatan,
                    $record->email,
                    $record->telepon,
                    $record->perusahaan,
                    $record->layanan,
                    $record->estimasi,
                    $record->lokasi,
                    $record->pesan,
                    $record->sumber,
                    $statusLabels[$record->status] ?? $record->status,
                ]);
            }

            fclose($handle);
        }, 'inquiries-'.now()->format('Y-m-d-His').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
