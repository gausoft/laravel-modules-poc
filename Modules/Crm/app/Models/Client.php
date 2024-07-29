<?php

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Attributes as OA;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Crm\Database\Factories\ClientFactory;

#[OA\Schema(
    schema: "Client",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "firstname", type: "string", example: "John"),
        new OA\Property(property: "lastname", type: "string", example: "Doe"),
        new OA\Property(property: "email", type: "string", format: "email", example: "john.doe@example.com"),
        new OA\Property(property: "phone", type: "string", example: "+1234567890"),
        new OA\Property(property: "address", type: "string", example: "123 Main St, Anytown, USA"),
        new OA\Property(property: "date_of_birth", type: "string", format: "date", example: "1980-01-01"),
        new OA\Property(property: "company", type: "string", example: "Doe Enterprises"),
        new OA\Property(property: "status", type: "string", example: "active"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2023-01-01T00:00:00Z"),
    ],
    required: ["firstname", "lastname", "email"]
)]
class Client extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'company',
        'status',
    ];

    protected static function newFactory(): Factory
    {
        return ClientFactory::new();
    }
}
