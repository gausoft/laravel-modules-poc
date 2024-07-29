<?php

namespace Modules\Stock\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Stock\Models\StockLocation;
use Symfony\Component\HttpFoundation\Response;

class StockLocationController extends Controller
{
    #[\OpenApi\Attributes\Get(
        path: "/api/v1/stock-locations",
        summary: "Get list of stock locations",
        tags: ["Stocks"],
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
            $locations = StockLocation::all();
            return response()->json($locations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Post(
        path: "/api/v1/stock-locations",
        summary: "Create a new stock location",
        tags: ["Stocks"],
        security: [
            ["sanctum" => []]
        ],
        requestBody: new \OpenApi\Attributes\RequestBody(
            required: true,
            content: new \OpenApi\Attributes\JsonContent(ref: "#/components/schemas/StockLocation")
        ),
        responses: [
            new \OpenApi\Attributes\Response(response: 201, description: "Created"),
            new \OpenApi\Attributes\Response(response: 400, description: "Bad Request"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $location = StockLocation::create($validated);
            return response()->json($location, Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Get(
        path: "/api/v1/stock-locations/{id}",
        summary: "Get a stock location by ID",
        tags: ["Stocks"],
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
            $location = StockLocation::findOrFail($id);
            return response()->json($location, Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Not Found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Put(
        path: "/api/v1/stock-locations/{id}",
        summary: "Update a stock location by ID",
        tags: ["Stocks"],
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
            content: new \OpenApi\Attributes\JsonContent(ref: "#/components/schemas/StockLocation")
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
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $location = StockLocation::findOrFail($id);
            $location->update($validated);
            return response()->json($location, Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Not Found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[\OpenApi\Attributes\Delete(
        path: "/api/v1/stock-locations/{id}",
        summary: "Delete a stock location by ID",
        tags: ["Stocks"],
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
            new \OpenApi\Attributes\Response(response: 204, description: "No Content"),
            new \OpenApi\Attributes\Response(response: 404, description: "Not Found"),
            new \OpenApi\Attributes\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function destroy(int $id)
    {
        try {
            $location = StockLocation::findOrFail($id);
            $location->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Not Found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
