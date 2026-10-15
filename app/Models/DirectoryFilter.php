<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DirectoryFilter extends Model
{
    public const GROUP_TYPE = 'type';

    public const GROUP_SECONDARY = 'secondary';

    public const GROUP_TERTIARY = 'tertiary';

    public const GROUPS = [
        self::GROUP_TYPE,
        self::GROUP_SECONDARY,
        self::GROUP_TERTIARY,
    ];

    protected $fillable = [
        'group',
        'slug',
        'title_es',
        'title_en',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeForGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function title(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->title_en ?: $this->title_es)
            : ($this->title_es ?: $this->title_en);
    }

    /**
     * @return array<string, string>
     */
    public static function optionsForGroup(string $group): array
    {
        return static::query()
            ->published()
            ->forGroup($group)
            ->ordered()
            ->get()
            ->mapWithKeys(fn (self $filter) => [$filter->slug => $filter->title()])
            ->all();
    }

    /**
     * @return array<string, list<array{value: string, label: string}>>
     */
    public static function groupedForFrontend(): array
    {
        $grouped = [
            self::GROUP_TYPE => [],
            self::GROUP_SECONDARY => [],
            self::GROUP_TERTIARY => [],
        ];

        static::query()
            ->published()
            ->ordered()
            ->get()
            ->each(function (self $filter) use (&$grouped) {
                if (! isset($grouped[$filter->group])) {
                    return;
                }

                $grouped[$filter->group][] = [
                    'value' => $filter->slug,
                    'label' => $filter->title(),
                ];
            });

        return $grouped;
    }
}
