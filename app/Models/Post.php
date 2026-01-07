<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 *
 * @property int $id
 * @property string $uuid
 * @property string $slug
 * @property int $project_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property bool $is_featured
 * @property string $post_type
 * @property string $status
 * @property string $visibility
 * @property int $position
 * @property int $views_count
 * @property string $lang
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $content
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Post|null $parent
 */
class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'slug',
        'is_featured',
        'post_type',
        'status',
        'visibility',
        'position',
        'views_count',
        'lang',
        'title',
        'subtitle',
        'description',
        'content',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured'  => 'bool',
        'views_count'  => 'int',
        'position'     => 'int',
        'metadata'     => 'array',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    /**
     * Get the project that owns the post.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent post.
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
}

