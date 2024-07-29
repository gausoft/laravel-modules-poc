<?php

namespace Modules\Accounting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CreateSaleRequest",
    type: "object",
    required: ["customer_id", "items"],
    properties: [
        new OA\Property(property: "customer_id", type: "integer", example: 1),
        new OA\Property(property: "notes", type: "string", example: "This is a note"),
        new OA\Property(property: "status", type: "string", example: "completed"),
        new OA\Property(
            property: "items",
            type: "array",
            items: new OA\Items(
                type: "object",
                required: ["product_id", "quantity"],
                properties: [
                    new OA\Property(property: "product_id", type: "integer", example: 1),
                    new OA\Property(property: "quantity", type: "integer", example: 1),
                ]
            )
        )
    ]
)]
class CreateSaleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:clients,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
