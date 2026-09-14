<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'user_id',
        'ticket_number',
        'title',
        'category',
        'priority',
        'status',
        'description',
        'rejection_reason',
        'attachment',
        'pdf_path',
    ];

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ComplaintReply::class)->oldest();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'déposée' => 'Déposée',
            'en_attente' => 'En attente',
            'avec_succès' => 'Avec succès',
            'refusée' => 'Refusée',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusBadgeVariantAttribute(): string
    {
        return match ($this->status) {
            'déposée' => 'info',
            'en_attente' => 'warning',
            'avec_succès' => 'success',
            'refusée' => 'danger',
            default => 'neutral',
        };
    }

    public function isRefused(): bool
    {
        return $this->status === 'refusée';
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress']);
    }

    public function scopeResolved(Builder $query): Builder
    {
        return $query->whereIn('status', ['avec_succès', 'resolved']);
    }

    public function scopeUrgent(Builder $query): Builder
    {
        return $query->where('priority', 'urgent');
    }
}
