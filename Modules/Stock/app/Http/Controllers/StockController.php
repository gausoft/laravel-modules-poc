<?php

namespace Modules\Stock\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Stock\Models\ProductStock;
use OpenApi\Attributes as OA;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/stocks',
        summary: 'Lister tous les produits en stock',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        responses: [
            new OA\Response(response: 200, description: 'Liste des produits en stock'),
            new OA\Response(response: 500, description: 'Erreur serveur')
        ]
    )]
    public function index()
    {
        try {
            $products = ProductStock::all();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }


    #[OA\Post(
        path: '/api/v1/stocks',
        summary: 'Ajouter un nouveau produit au stock',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/ProductStock')
        ),
        responses: [
            new OA\Response(response: 201, description: 'Produit créé avec succès'),
            new OA\Response(response: 400, description: 'Requête invalide'),
            new OA\Response(response: 500, description: 'Erreur serveur')
        ]
    )]
    public function store(Request $request)
    {
        try {
            $product = ProductStock::create($request->all());
            return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    #[OA\Get(
        path: '/api/v1/stocks/{id}',
        summary: 'Afficher les détails d\'un produit spécifique en stock',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Détails du produit'),
            new OA\Response(response: 404, description: 'Produit non trouvé'),
            new OA\Response(response: 500, description: 'Erreur serveur')
        ]
    )]
    public function show($id)
    {
        try {
            $product = ProductStock::findOrFail($id);
            return response()->json($product);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }


    #[OA\Put(
        path: '/api/v1/stocks/{id}',
        summary: 'Mettre à jour les informations d\'un produit en stock',
        tags: ['Stocks'],
        security: [
            ["sanctum" => []]
        ],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/Product')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Produit mis à jour avec succès'),
            new OA\Response(response: 400, description: 'Requête invalide'),
            new OA\Response(response: 404, description: 'Produit non trouvé'),
            new OA\Response(response: 500, description: 'Erreur serveur')
        ]
    )]
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $product = ProductStock::findOrFail($id);
            $product->update($request->all());
            return response()->json($product);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }
}
