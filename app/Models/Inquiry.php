<?php

namespace App\Models;

use App\Traits\FilterByProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Inquiry
 *
 * @property int $id
 * @property int $project_id
 * @property int|null $user_id
 * @property bool $is_read
 * @property bool $is_spam
 * @property bool $is_archived
 * @property string $name
 * @property string $email
 * @property string|null $subject
 * @property string $message
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $terms_accepted_at
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User|null $user
 */
class Inquiry extends Model
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
        'is_read',
        'is_spam',
        'is_archived',
        'name',
        'email',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'terms_accepted_at',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read'           => 'bool',
        'is_spam'           => 'bool',
        'is_archived'       => 'bool',
        'terms_accepted_at' => 'datetime',
        'metadata'          => 'array',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    /**
     * Get the project that owns the inquiry.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the inquiry.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}