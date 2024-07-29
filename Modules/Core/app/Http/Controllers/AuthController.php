<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Core"},
     *     summary="User login",
     *     description="Authenticate user and return a token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-token-here")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = auth()->user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Core"},
     *     security={ {"sanctum": {} }},
     *     summary="User logout",
     *     description="Logout the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Core"},
     *     security={ {"sanctum": {} }},
     *     summary="Get authenticated user",
     *     description="Get the details of the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function me()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/{user_id}/roles",
     *     tags={"Core"},
     *     security={ {"sanctum": {} }},
     *     summary="Assign role to user",
     *     description="Assign a role to a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","role"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="role", type="string", example="admin"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role assigned successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Role assigned successfully")
     *         )
     *     )
     * )
     */
    public function assignRole(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $roles = $request->input('roles');

        if ($user && Role::whereIn('name', $roles)->exists()) {
            $user->syncRoles($roles);
            return response()->json(['message' => 'Roles assigned successfully'], 200);
        } else {
            return response()->json(['message' => 'User or role not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/roles",
     *     tags={"Core"},
     *     security={ {"sanctum": {} }},
     *     summary="Create a new role",
     *     description="Create a new role in the system",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="admin"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function createRole(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        $role = Role::create(['name' => $validatedData['name']]);

        return response()->json(['role' => $role], 201);
    }
}
