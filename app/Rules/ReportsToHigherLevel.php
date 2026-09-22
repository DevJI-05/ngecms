<?php

namespace App\Rules;

use App\Models\TeamMember;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ReportsToHigherLevel implements ValidationRule
{
    /**
     * Organizational levels ordered from highest to lowest authority.
     *
     * @var array<int, string>
     */
    private const LEVEL_ORDER = ['komisaris', 'direksi', 'manajer', 'staff'];

    public function __construct(private readonly ?string $level) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $this->level === null) {
            return;
        }

        $parentLevel = TeamMember::query()->whereKey($value)->value('level');

        if ($parentLevel === null) {
            return;
        }

        $childRank = array_search($this->level, self::LEVEL_ORDER, true);
        $parentRank = array_search($parentLevel, self::LEVEL_ORDER, true);

        if ($childRank === false || $parentRank === false) {
            return;
        }

        if ($parentRank >= $childRank) {
            $fail('Reports To must be a member with a higher level than the selected Level.');
        }
    }
}
