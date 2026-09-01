<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\CompanyValue;
use App\Models\Milestone;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        $settings = SiteSetting::current();

        return Inertia::render('gas/About', [
            'values' => CompanyValue::query()->orderBy('sort_order')->get(),
            'timeline' => Milestone::query()->orderBy('year')->get(),
            'teamMembers' => TeamMember::query()->orderBy('sort_order')->get(),
            'certifications' => Certification::query()->orderBy('sort_order')->get(),
            'settings' => $settings,
            'stats' => [
                'projectsCompleted' => "{$settings->stat_projects_completed}+",
                'employees' => "{$settings->stat_employees}+",
                'provinces' => (string) $settings->stat_provinces,
            ],
        ]);
    }
}
