<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'role',
        'level',
        'initials',
        'avatar_bg',
        'avatar_color',
        'sort_order',
    ];

    /**
     * @return BelongsTo<TeamMember, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<TeamMember, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get the IDs of all descendants (children, grandchildren, ...) of the given team member.
     *
     * @return array<int, int>
     */
    public static function descendantIds(int $id): array
    {
        $ids = [];
        $queue = [$id];

        while ($queue !== []) {
            $childIds = self::query()->whereIn('parent_id', $queue)->pluck('id')->all();
            $childIds = array_values(array_diff($childIds, $ids));

            if ($childIds === []) {
                break;
            }

            $ids = [...$ids, ...$childIds];
            $queue = $childIds;
        }

        return $ids;
    }
}
