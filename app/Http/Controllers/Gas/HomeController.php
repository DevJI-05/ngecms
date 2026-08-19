<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $settings = SiteSetting::current();

        return Inertia::render('gas/Home', [
            'services' => Service::query()
                ->orderBy('sort_order')
                ->limit(6)
                ->get(['icon', 'icon_bg', 'icon_color', 'name', 'description']),
            'projects' => PortfolioProject::query()
                ->orderBy('sort_order')
                ->limit(4)
                ->get(['cat', 'name', 'location', 'year', 'specs']),
            'stats' => [
                'projectsCompleted' => $settings->stat_projects_completed,
                'pipelineKm' => $settings->stat_pipeline_km,
                'yearsExperience' => $settings->stat_years_experience,
            ],
        ]);
    }
}
