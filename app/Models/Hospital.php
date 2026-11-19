<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // สำคัญ: ใช้แทน Model
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'hospcode',
        'name',
        'token_api',
        'contact',
        'is_active',
    ];

    protected $hidden = [
        'token_api',
        'password',
        'remember_token',
    ];

    protected $casts = [
    'is_active' => 'boolean',
    ];

    // ถ้าใช้ hospcode เป็นตัว login
    public function getAuthIdentifierName()
    {
        return 'hospcode';
    }

    /**
     * Determine if the current API token has a given ability.
     * Overrides HasApiTokens to ensure authenticated Hospital models always pass if valid.
     */
    public function tokenCan(string $ability): bool
    {
        if ($this->accessToken) {
            return $this->accessToken->can($ability) || $this->accessToken->can('*');
        }
        return true;
    }
}
