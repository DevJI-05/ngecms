<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function __invoke(): Response
    {
        $settings = SiteSetting::current();

        return Inertia::render('gas/Portfolio', [
            'projects' => PortfolioProject::query()->orderBy('sort_order')->get(),
            'stats' => [
                'totalProjects' => $settings->stat_projects_completed,
                'pipelineKm' => $settings->stat_pipeline_km,
                'activeClients' => $settings->stat_active_clients,
                'provinces' => $settings->stat_provinces,
            ],
        ]);
    }
}
