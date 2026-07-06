<?php

namespace App\Models;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\Language;
use App\Traits\FilterByProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tag
 *
 * @property int $id
 * @property string $uuid
 * @property int $project_id
 * @property bool $is_published
 * @property string $tag_type
 * @property string $lang
 * @property int $views_count
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Project $project
 */
class Tag extends Model
{
    use SoftDeletes;
    use FilterByProject;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'content_type',
        'is_published',
        'tag_type',
        'lang',
        'views_count',
        'name',
        'project_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lang' => Language::class,
        'is_published' => 'bool',
        'views_count'  => 'int',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    /**
     * Get the project that owns the tag.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function scopeByContentType(Builder $query, null|string|ContentContentType $contentType =ContentContentType::Article->value): void
    {
        $value = $contentType instanceof ContentContentType ? $contentType->value : $contentType;
        $query->where('content_type',$value);
    }
}