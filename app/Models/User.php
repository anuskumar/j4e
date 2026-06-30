<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, MustVerifyEmailTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_added_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function defaultProfileImageUrl(): string
    {
        return asset('assets/img/customers/customer1.jpg');
    }

    public function profileImageUrl(): string
    {
        if ($this->profile) {
            return asset('storage/uploads/images/' . $this->profile);
        }

        if (in_array($this->user_type, ['admin', 'superadmin'], true)) {
            return asset('admin_assets/img/faces/6.jpg');
        }

        return self::defaultProfileImageUrl();
    }
}
