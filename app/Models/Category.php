<?php

namespace App\Models;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Traits\FilterByProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $uuid
 * @property int $project_id
 * @property int|null $parent_id
 * @property string $status
 * @property string $visibility
 * @property string $content_type
 * @property int $position
 * @property string $slug
 * @property string $lang
 * @property string $title
 * @property string|null $excerpt
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\Category|null $parent
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FilterByProject;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'status',
        'visibility',
        'content_type',
        'position',
        'slug',
        'lang',
        'title',
        'excerpt',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'position' => 'integer',
    ];

    /**
     * Get the project that owns the category.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function scopePublishedByType(Builder $query, string $contentType =ContentContentType::Article->value): void
    {
        $query->where('status', ContentStatus::Published->value)
              ->where('content_type', $contentType);
    }
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('slug')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }
}