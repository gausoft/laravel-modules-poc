<?php

namespace Modules\Stock\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Exception;
use Modules\Stock\Models\Product;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: '/api/v1/products',
        summary: 'Récupérer la liste des produits',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des produits',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Product'))
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Post(
        path: '/api/v1/products',
        summary: 'Créer un nouveau produit',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/Product')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Produit créé',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function store(Request $request)
    {
        try {
            $product = Product::create($request->all());
            return response()->json($product, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Get(
        path: '/api/v1/products/{id}',
        summary: 'Récupérer les détails d\'un produit',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du produit',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Put(
        path: '/api/v1/products/{id}',
        summary: 'Mettre à jour un produit',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/Product')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Produit mis à jour',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Delete(
        path: '/api/v1/products/{id}',
        summary: 'Supprimer un produit',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Produit supprimé'
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
