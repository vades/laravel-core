<?php

namespace App\Models;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use App\Traits\FilterByProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Content
 *
 * @property int $id
 * @property string $uuid
 * @property int $project_id
 * @property int $user_id
 * @property int|null $author_id
 * @property int|null $parent_id
 * @property string $content_type
 * @property string $status
 * @property string $visibility
 * @property string $lang
 * @property string $slug
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $excerpt
 * @property string|null $content
 * @property array|null $metadata
 * @property int $position
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\Content|null $parent
 */
class Content extends Model
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
        'project_id',
        'user_id',
        'author_id',
        'parent_id',
        'content_type',
        'status',
        'visibility',
        'lang',
        'slug',
        'title',
        'subtitle',
        'excerpt',
        'content',
        'metadata',
        'position',
        'is_featured',
        'published_at',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => ContentStatus::class,
        'content_type' => ContentContentType::class,
        'visibility' => ContentVisibility::class,
        'lang' => Language::class,
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'position' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Get the project that owns the content.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user (creator) who created the content.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the author of the content (if different from creator).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the parent content.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'parent_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_content');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'content_tag');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('slug')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the cover image URL from metadata.
     */
    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['coverImage'] ?? null,
        );
    }
    /**
     * Get the featured image URL from metadata.
     */
    protected function featuredImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['featuredImage'] ?? null,
        );
    }

    /**
     * Get the address from metadata.
     */
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['address'] ?? null,
        );
    }

    /**
     * Get the Google Map Embed URL from metadata.
     */
    protected function googleMapEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['googleMapEmbedUrl'] ?? null,
        );
    }

    /**
     * Get the Meta Title from metadata.
     */
    protected function metaTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['metaTitle'] ?? null,
        );
    }

    /**
     * Get the Meta Description from metadata.
     */
    protected function metaDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metadata['metaDescription'] ?? null,
        );
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', ContentStatus::Published->value);
    }

    public function scopePublishedByType(Builder $query, string|ContentContentType $contentType = ContentContentType::Article->value):
    void
    {
        $value = $contentType instanceof ContentContentType ? $contentType->value : $contentType;
        $query->where('status', ContentStatus::Published->value)
              ->where('content_type', $value)
        ;
    }
    public function scopeIsFeatured(Builder $query): void
    {
        $query->where('is_featured', 1);
    }

    public function scopeNotFeatured(Builder $query): void
    {
        $query->where('is_featured', 0);
    }

    public function scopeFilter(Builder $query, Request $request): void
    {
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', '=', $request->input('category'));
            });
        });
        $query->when($request->filled('tag'), function ($q) use ($request) {
            $q->whereHas('tags', function ($q) use ($request) {
                $q->where('name', '=', $request->input('tag'));
            });
        });
    }

    public function nextPublishedByType(string|ContentContentType $contentType =ContentContentType::Article->value)
    {
        $value = $contentType instanceof ContentContentType ? $contentType->value : $contentType;
        return $this->publishedByType( $value)
                    ->where('id', '>', $this->id)
                    ->orderBy('id')
                    ->first();
    }

    public function previousPublishedByType(string|ContentContentType $contentType = ContentContentType::Article->value)
    {
        $value = $contentType instanceof ContentContentType ? $contentType->value : $contentType;
        return $this->publishedByType($contentType)
                    ->where('id', '<', $this->id)
                    ->orderByDesc('id')
                    ->first();
    }
}