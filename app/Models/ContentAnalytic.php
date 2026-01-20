<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $content_id
 * @property int $project_id
 * @property int $views
 * @property int $unique_views
 * @property int $downloads
 * @property \Illuminate\Support\Carbon|null $last_viewed_at
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Content $content
 */
class ContentAnalytic extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'views',
        'unique_views',
        'downloads',
        'last_viewed_at',
        'metadata',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'views' => 'int',
        'unique_views' => 'int',
        'downloads' => 'int',
        'last_viewed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the content that owns the analytic.
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}