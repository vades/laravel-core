<?php

namespace App\Models;

use App\Enums\WidgetContentType;
use App\Enums\ContentStatus;
use App\Enums\Language;
use App\Traits\HasDynamicContent;
use App\Traits\FilterByProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Widget
 */
class Widget extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FilterByProject;
    use HasDynamicContent;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'widget_type',
        'status',
        'lang',
        'slug',
        'has_icon',
        'title',
        'content',
        'metadata',
        'footer',
        'position',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => ContentStatus::class,
        'content_type' => WidgetContentType::class,
        'lang' => Language::class,
        'metadata' => 'array',
        'position' => 'integer',
    ];

    /**
     * Get the project that owns the content.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('title')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get rendered content.
     */
    protected function renderedContent(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->content)->markdown(),
        );
    }

    /**
     * Get the cover image URL from metadata.
     */

    protected function hasIcon(): Attribute
    {
       return Attribute::make(
            get: fn () => !empty($this->metadata['coverImage'])
                ? Storage::disk('external_images')->url($this->metadata['coverImage'])
                : null,
        );
    }
    
    public function scopePublishedByType(Builder $query):
    void
    {
        $query->where('status', ContentStatus::Published->value);
    }
}
