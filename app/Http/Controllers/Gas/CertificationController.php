<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class CertificationController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('gas/Certifications', [
            'certifications' => Certification::query()->orderBy('sort_order')->get(),
            'settings' => SiteSetting::current(),
        ]);
    }
}
