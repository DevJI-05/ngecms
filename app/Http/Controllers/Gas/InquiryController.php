<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class InquiryController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('gas/Inquiry', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
