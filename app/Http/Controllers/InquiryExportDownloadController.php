<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryExportDownloadController extends Controller
{
    public function __invoke(Request $request, string $exportId): StreamedResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $progress = Cache::get("inquiry-export:{$exportId}");

        abort_if(
            ! $progress || ($progress['status'] ?? null) !== 'done' || ! Storage::disk('local')->exists($progress['file'] ?? ''),
            404,
        );

        $path = $progress['file'];
        $fileName = 'inquiries-'.now()->format('Y-m-d-His').'.xlsx';

        return response()->streamDownload(function () use ($path, $exportId): void {
            $stream = Storage::disk('local')->readStream($path);
            fpassthru($stream);
            fclose($stream);

            Storage::disk('local')->delete($path);
            Cache::forget("inquiry-export:{$exportId}");
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }
}
