<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AllyApplication extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_REVIEWED = 'reviewed';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'business_name',
        'business_type',
        'description',
        'phone',
        'website',
        'photos',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
        ];
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_REVIEWED => 'Revisada',
            self::STATUS_ARCHIVED => 'Archivada',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusOptions()[$this->status] ?? $this->status;
    }
}
