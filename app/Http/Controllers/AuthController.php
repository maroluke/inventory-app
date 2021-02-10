<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      operationId="register",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Adds a new user",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The name of the new user.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="The e-mail-address of the new user.",
     *         required=true,
     *         @OA\Schema(type="email")
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="path",
     *         description="The password for the new user.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="password_confirmation",
     *         in="path",
     *         description="The confirmation for the password.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *     )
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Login and get a token",
     *      description="Log in with a existing user and get a JWT.",
     *      @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="The e-mail-address of the new user.",
     *         required=true,
     *         @OA\Schema(type="email")
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="path",
     *         description="The password for the new user.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Wrong username or password."
     *       ),
     *     )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/me",
     *      operationId="me",
     *      tags={"Auth"},
     *      summary="Show the current user",
     *      description="Return information from the current user.",
     *      @OA\Parameter(
     *         name="token",
     *         in="header",
     *         description="The JWT from the session.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Not logged in!"
     *       ),
     *     )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Log out current user",
     *      description="Invalidate the token of the current user.",
     *      @OA\Parameter(
     *         name="token",
     *         in="header",
     *         description="The JWT from the session.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="refresh",
     *      tags={"Auth"},
     *      summary="Refresh the current token",
     *      description="Reset the timer for the token of the current user.",
     *      @OA\Parameter(
     *         name="token",
     *         in="header",
     *         description="The JWT from the session.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}