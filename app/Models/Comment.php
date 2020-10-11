<?php

namespace App\Models;

use App\Contracts\HasStatus;
use App\Models\Post;
use App\Models\User;
use App\Scopes\Approved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model implements HasStatus
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new Approved());
    }

    /**
     * The user who created this comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Comment post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get a value representing the "Approved" status.
     *
     * @return mixed
     */
    public function getApprovedStatus()
    {
        return 1;
    }

    /**
     * Approve this model.
     *
     * @return self
     */
    public function approve(): self
    {
        $this->status = 1;
        $this->save();

        return $this;
    }

    /**
     * Reject this model.
     *
     * @return self
     */
    public function reject(): self
    {
        $this->status = 3;
        $this->save();

        return $this;
    }
}
