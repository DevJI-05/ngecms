<?php

namespace App\Http\Controllers;

use App\Support\InquiryXlsxExporter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        return InquiryXlsxExporter::streamDownload();
    }
}
