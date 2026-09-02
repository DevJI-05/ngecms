<?php

namespace App\Support;

class CompanyValueIcons
{
    /**
     * Curated Tabler Icons (ti-*) relevant to company values, used to
     * populate the icon picker on the Company Value resource form. The same
     * class renders identically via <i class="ti ti-*"> in the Filament
     * admin and on the public site (see GasValueCard.vue).
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            'ti-shield-check' => 'Integrity / Trust',
            'ti-users-group' => 'Teamwork',
            'ti-heart' => 'Care / Passion',
            'ti-rocket' => 'Growth / Innovation',
            'ti-star' => 'Excellence',
            'ti-bulb' => 'Innovation / Ideas',
            'ti-badge' => 'Quality',
            'ti-scale' => 'Fairness / Balance',
            'ti-thumb-up' => 'Reliability',
            'ti-trophy' => 'Achievement',
            'ti-bolt' => 'Speed / Energy',
            'ti-flag' => 'Mission / Goal',
            'ti-clock' => 'Punctuality',
            'ti-chart-bar' => 'Performance',
            'ti-certificate' => 'Certification',
            'ti-award' => 'Recognition',
        ];
    }
}
