<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_key',
        'label',
        'cms_enabled',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'cms_enabled' => 'boolean',
            'content' => 'array',
        ];
    }

    public static function key(string $pageKey): self
    {
        return static::query()->firstOrCreate(
            ['page_key' => $pageKey],
            [
                'label' => str($pageKey)->headline()->toString(),
                'cms_enabled' => false,
                'content' => [],
            ],
        );
    }

    public function scopeForKey(Builder $query, string $pageKey): Builder
    {
        return $query->where('page_key', $pageKey);
    }
}
