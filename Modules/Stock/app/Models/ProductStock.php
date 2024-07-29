<?php

namespace Modules\Stock\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stock\Database\Factories\ProductStockFactory;
use OpenApi\Attributes as OA;
use OwenIt\Auditing\Contracts\Auditable;

#[OA\Schema(
    schema: "ProductStock",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "product_id", type: "integer", example: 101),
        new OA\Property(property: "quantity", type: "integer", example: 50),
        new OA\Property(property: "movement_type", type: "string", example: "in"),
        new OA\Property(property: "location_id", type: "integer", example: 5),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2023-01-01T00:00:00Z"),
    ],
    required: ["product_id", "quantity", "location_id"]
)]
class ProductStock extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'movement_type',
        'reason',
        'location_id',
    ];
}
