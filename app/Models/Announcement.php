<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'residence_id',
        'user_id',
        'title',
        'content',
        'type',
        'pinned',
        'published_at',
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function residence(): BelongsTo
    {
        return $this->belongsTo(Residence::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePinnedFirst(Builder $query): Builder
    {
        return $query->orderBy('pinned', 'desc')->orderBy('published_at', 'desc');
    }
}
