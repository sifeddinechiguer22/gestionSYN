<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Residence extends Model
{
    use HasFactory;

    protected $fillable = [
        'syndic_id',
        'name',
        'address',
        'city',
        'postal_code',
        'total_apartments',
    ];

    public function syndic()
    {
        return $this->belongsTo(User::class, 'syndic_id');
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }
}
