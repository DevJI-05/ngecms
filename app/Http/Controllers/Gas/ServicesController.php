<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class ServicesController extends Controller
{
    public function __invoke(): Response
    {
        $settings = SiteSetting::current();

        return Inertia::render('gas/Services', [
            'services' => Service::query()->orderBy('sort_order')->get(),
            'stats' => [
                'serviceCount' => Service::query()->count(),
                'pipelineKm' => "{$settings->stat_pipeline_km} km",
                'projectsCompleted' => "{$settings->stat_projects_completed}+",
            ],
        ]);
    }
}
