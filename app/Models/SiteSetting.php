<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'cms_enabled',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'cms_enabled' => 'boolean',
            'data' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            [
                'cms_enabled' => false,
                'data' => [],
            ],
        );
    }
}
