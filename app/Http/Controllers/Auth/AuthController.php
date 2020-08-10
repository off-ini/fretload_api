<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where(['username' => $request->username, 'password' => md5($request->password)])->first();
        if (!$user || ! $token = Auth::login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $roles = [];
        $permissions = [];
        foreach($user->role_users as $role_users)
        {
            $roles[] = $role_users->role->libelle;
            foreach($role_users->permissions as $permission)
            {
                $permissions[] = $permission->tag;
            }
        }
        return $this->respondWithUserWithToken($token, $user, $roles, $permissions);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //dd(Auth::user()->with('role_users.role', 'role_users.permissions')->get());
        //$user = User::where(['id' => Auth::user()->id])->with('role_users.role', 'role_users.permissions')->get();
        try {
            return response()->json(Auth::user(), 200);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::refresh());
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    protected function respondWithUserWithToken($token, $user, $roles, $permissions)
    {
        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
