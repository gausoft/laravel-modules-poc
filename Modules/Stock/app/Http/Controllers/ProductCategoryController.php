<?php

namespace Modules\Stock\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Stock\Models\ProductCategory;
use OpenApi\Attributes as OA;

class ProductCategoryController extends Controller
{
    #[OA\Get(
        path: "/api/v1/categories",
        summary: "Get list of product categories",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/ProductCategory"))
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    public function index(): JsonResponse
    {
        try {
            $categories = ProductCategory::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    #[OA\Post(
        path: "/api/v1/categories",
        summary: "Create a new product category",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ProductCategory")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Category created successfully",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductCategory")
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        try {
            $category = ProductCategory::create($request->all());
            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }

    #[OA\Get(
        path: "/api/v1/categories/{id}",
        summary: "Get a product category by ID",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductCategory")
            ),
            new OA\Response(
                response: 404,
                description: "Category not found"
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    public function show($id): JsonResponse
    {
        try {
            $category = ProductCategory::findOrFail($id);
            return response()->json($category, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    #[OA\Put(
        path: "/api/v1/categories/{id}",
        summary: "Update a product category by ID",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ProductCategory")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Category updated successfully",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductCategory")
            ),
            new OA\Response(
                response: 404,
                description: "Category not found"
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->update($request->all());
            return response()->json($category, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    #[OA\Delete(
        path: "/api/v1/categories/{id}",
        summary: "Delete a product category by ID",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Category deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Category not found"
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error"
            )
        ]
    )]
    public function destroy($id): JsonResponse
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();
            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
