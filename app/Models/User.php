<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

use OpenApi\Attributes as OA;
use OwenIt\Auditing\Contracts\Auditable;

#[OA\Schema(
    schema: 'User',
    title: 'User',
    description: 'User model',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID de l\'utilisateur'),
        new OA\Property(property: 'name', type: 'string', description: 'Nom de l\'utilisateur'),
        new OA\Property(property: 'email', type: 'string', description: 'Email de l\'utilisateur'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Date de création'),
    ],
    type: 'object'
)]
class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, \OwenIt\Auditing\Auditable;

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
