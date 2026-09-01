<?php

use App\Models\SiteSetting;
use Inertia\Testing\AssertableInertia as Assert;

test('public homepage reflects updated site settings', function () {
    SiteSetting::current()->update([
        'company_name' => 'Updated Company Name',
        'tagline' => 'Updated Tagline',
        'whatsapp_number' => '6289999999999',
    ]);

    $this->get('/')
        ->assertInertia(fn (Assert $page) => $page
            ->where('siteSettings.company_name', 'Updated Company Name')
            ->where('siteSettings.tagline', 'Updated Tagline')
            ->where('siteSettings.whatsapp_number', '6289999999999')
        );
});

test('public homepage formats numeric stats with a display suffix', function () {
    SiteSetting::current()->update([
        'stat_projects_completed' => 250,
        'stat_pipeline_km' => 600,
        'stat_years_experience' => 18,
    ]);

    $this->get('/')
        ->assertInertia(fn (Assert $page) => $page
            ->where('stats.projectsCompleted', '250+')
            ->where('stats.pipelineKm', '600 km')
            ->where('stats.yearsExperience', '18+')
        );
});
