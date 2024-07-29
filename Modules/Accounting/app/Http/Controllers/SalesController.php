<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Http\Requests\CreateSaleRequest;
use Modules\Accounting\Models\Sale;
use Modules\Accounting\Models\SaleItem;
use Modules\Stock\Contracts\StockServiceInterface;
use Modules\Stock\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends Controller
{
    #[\OpenApi\Attributes\Get(
        path: "/api/v1/sales",
        summary: "Get list of sales",
        tags: ["Accounting"],
        security: [
            ["sanctum" => []]
        ],
        responses: [
            new \OpenApi\Attributes\Response(response: 200, description: "Successful operation"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function index()
    {
        try {
            $sales = Sale::with('items')->get();
            return response()->json($sales, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Get(
        path: "/api/v1/sales/{id}",
        summary: "Get a sale by ID",
        tags: ["Accounting"],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new \OpenApi\Attributes\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new \OpenApi\Attributes\Schema(type: "integer")
            )
        ],
        responses: [
            new \OpenApi\Attributes\Response(response: 200, description: "Successful operation"),
            new \OpenApi\Attributes\Response(response: 404, description: "Not Found"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function show(int $id)
    {
        try {
            $sale = Sale::with('items')->findOrFail($id);
            return response()->json($sale, Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Post(
        path: "/api/v1/sales",
        summary: "Create a new sale",
        tags: ["Accounting"],
        security: [
            ["sanctum" => []]
        ],
        requestBody: new \OpenApi\Attributes\RequestBody(
            required: true,
            content: new \OpenApi\Attributes\JsonContent(ref: "#/components/schemas/CreateSaleRequest")
        ),
        responses: [
            new \OpenApi\Attributes\Response(response: 201, description: "Created"),
            new \OpenApi\Attributes\Response(response: 400, description: "Bad Request"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function store(CreateSaleRequest $request, StockServiceInterface $stockService)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $items = $data['items'];

            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'status' => $data['status'] ?? 'completed',
                'notes' => $data['notes'] ?? ''
            ]);

            collect($items)->each(function ($item) use ($stockService, $sale) {
                if (!$stockService->hasSufficientStock($item['product_id'], $item['quantity'])) {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Insufficient stock for product ID ' . $item['product_id']
                    ], Response::HTTP_BAD_REQUEST);
                }

                $product = Product::findOrFail($item['product_id']);

                $saleItem = new SaleItem([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity']
                ]);

                $sale->items()->save($saleItem);

                $stockService->decreaseStock($item['product_id'], $item['quantity']);
            });

            $sale->update(['total_amount' => $sale->items->sum(fn ($item) => $item->quantity * $item->unit_price)]);
            $sale->refresh();

            DB::commit();

            return response()->json($sale, Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $message = app()->environment('production') ? 'Internal Server Error' : $e->getMessage();
            return response()->json(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollBack();
        }
    }

    #[\OpenApi\Attributes\Put(
        path: "/api/v1/sales/{id}",
        summary: "Update a sale by ID",
        tags: ["Accounting"],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new \OpenApi\Attributes\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new \OpenApi\Attributes\Schema(type: "integer")
            )
        ],
        requestBody: new \OpenApi\Attributes\RequestBody(
            required: true,
            content: new \OpenApi\Attributes\JsonContent(ref: "#/components/schemas/Sale")
        ),
        responses: [
            new \OpenApi\Attributes\Response(response: 200, description: "Successful operation"),
            new \OpenApi\Attributes\Response(response: 400, description: "Bad Request"),
            new \OpenApi\Attributes\Response(response: 404, description: "Not Found"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function update(Request $request, int $id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->update($request->all());
            return response()->json($sale, Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Not Found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
