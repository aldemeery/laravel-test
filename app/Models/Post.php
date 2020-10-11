<?php

namespace App\Models;

use App\Contracts\HasStatus;
use App\Contracts\Moderated;
use App\Models\Comment;
use App\Models\User;
use App\Scopes\Approved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model implements HasStatus, Moderated
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
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
     * The user who created this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get a value representing the "Approved" status.
     *
     * @return mixed
     */
    public function getApprovedStatus()
    {
        return 'approved';
    }

    /**
     * Get the text used for moderation.
     *
     * @return string
     */
    public function getModerationText(): string
    {
        return "{$this->title} {$this->content}";
    }

    /**
     * Approve this model.
     *
     * @return self
     */
    public function approve(): self
    {
        $this->status = 'approved';
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
        $this->status = 'rejected';
        $this->save();

        return $this;
    }
}
