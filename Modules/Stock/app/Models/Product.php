<?php

namespace Modules\Stock\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Attributes as OA;
use OwenIt\Auditing\Contracts\Auditable;

#[OA\Schema(
    schema: 'Product',
    title: 'Product',
    description: 'Product model',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID du produit'),
        new OA\Property(property: 'name', type: 'string', description: 'Nom du produit'),
        new OA\Property(property: 'sku', type: 'string', description: 'SKU du produit'),
        new OA\Property(property: 'description', type: 'string', description: 'Description du produit'),
        new OA\Property(property: 'is_active', type: 'boolean', description: 'Statut actif du produit'),
        new OA\Property(property: 'price', type: 'number', format: 'float', description: 'Prix du produit'),
        new OA\Property(property: 'quantity', type: 'integer', description: 'Quantité en stock'),
        new OA\Property(property: 'low_stock_threshold', type: 'integer', description: 'Seuil de stock bas'),
        new OA\Property(property: 'category_id', type: 'integer', description: 'ID de la catégorie'),
        new OA\Property(property: 'attributes', type: 'string', description: 'Attributs supplémentaires du produit'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Date de création'),
    ],
    type: 'object'
)]
class Product extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'is_active',
        'price',
        'quantity',
        'low_stock_threshold',
        'category_id',
        'attributes',
    ];
}
