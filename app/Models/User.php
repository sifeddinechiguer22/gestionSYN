<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'password',
    ];

    /**
     * Check if user has syndic role.
     */
    public function isSyndic(): bool
    {
        return $this->role === 'syndic';
    }

    /**
     * Check if user has resident role.
     */
    public function isResident(): bool
    {
        return $this->role === 'resident';
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'user_id');
    }

    public function apartment()
    {
        return $this->hasOne(Apartment::class, 'user_id');
    }

    public function managedResidence()
    {
        return $this->hasOne(Residence::class, 'syndic_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
