<?php

namespace Modules\Stock\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stock\Database\Factories\ProductCategoryFactory;
use OpenApi\Attributes as OA;
use OwenIt\Auditing\Contracts\Auditable;

#[OA\Schema(
    schema: "ProductCategory",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Electronics"),
        new OA\Property(property: "description", type: "string", example: "Category for electronic products"),
        new OA\Property(property: "parent_id", type: "integer", nullable: true, example: 0),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2023-01-01T00:00:00Z"),
    ],
    required: ["name"]
)]
class ProductCategory extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
    ];
}
