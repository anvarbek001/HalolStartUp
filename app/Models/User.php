<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BrendStatus;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class);
    }

    public function brandStatus()
    {
        if ($this->brand->status == BrendStatus::ACTIVE->value) {
            return '✅' . BrendStatus::ACTIVE->label();
        } elseif ($this->brand->status == BrendStatus::INACTIVE->value) {
            return '⚪' . BrendStatus::INACTIVE->label();
        } elseif ($this->brand->status == BrendStatus::PENDING->value) {
            return '⏳' . BrendStatus::PENDING->label();
        } elseif ($this->brand->status == BrendStatus::BLOCKED->value) {
            return '🚫' . BrendStatus::BLOCKED->label();
        }
    }

    public function getUserBrand()
    {
        return $this->brands()->where('user_id', Auth()->user->id)->first();
    }

    public function parties(): HasMany
    {
        return $this->hasMany(Party::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function userBalance(): HasOne
    {
        return $this->hasOne(UserBalance::class);
    }

    public function partieshistories(): HasMany
    {
        return $this->hasMany(PartiesHistory::class);
    }
}
