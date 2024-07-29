<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounting\Database\Factories\SaleFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Sale",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "customer_id", type: "integer", example: 1),
        new OA\Property(property: "total_amount", type: "number", format: "float", example: 100.00),
        new OA\Property(property: "status", type: "string", example: "completed"),
        new OA\Property(property: "notes", type: "string", example: "This is a sample sale"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2023-01-01T00:00:00Z"),
    ],
    required: ["customer_id", "total_amount", "status"]
)]
class Sale extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
