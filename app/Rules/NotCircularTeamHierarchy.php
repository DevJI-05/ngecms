<?php

namespace App\Rules;

use App\Models\TeamMember;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotCircularTeamHierarchy implements ValidationRule
{
    public function __construct(private readonly ?int $recordId) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $this->recordId === null) {
            return;
        }

        if ((int) $value === $this->recordId) {
            $fail('A team member cannot report to themselves.');

            return;
        }

        if (in_array((int) $value, TeamMember::descendantIds($this->recordId), true)) {
            $fail('This would create a circular reporting hierarchy.');
        }
    }
}
