<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PasswordResetCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public static function createForEmail(string $email): string
    {
        static::where('email', $email)->delete();

        $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        static::create([
            'email' => $email,
            'code' => Hash::make($plainCode),
            'expires_at' => now()->addMinutes(15),
        ]);

        return $plainCode;
    }

    public static function verify(string $email, string $plainCode): ?self
    {
        $record = static::where('email', $email)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (! $record || ! Hash::check($plainCode, $record->code)) {
            return null;
        }

        return $record;
    }

    public function markUsed(): void
    {
        $this->used_at = now();
        $this->save();
    }
}
