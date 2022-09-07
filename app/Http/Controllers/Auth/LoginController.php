<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     @OA\RequestBody (
     *         required=true,
     *         description="Registration credentials",
     *         @OA\JsonContent(
     *              @OA\Property (type="string", property="name"),
     *              @OA\Property (type="string", property="email", format="email"),
     *              @OA\Property (type="string", property="password"),
     *              @OA\Property (type="string", property="password_confirmation"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully registered",
     *          @OA\JsonContent(
     *              @OA\Property (property="user", ref="#/components/schemas/user"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *              @OA\Property (property="message", type="string"),
     *              @OA\Property (property="errors", type="object"),
     *          ),
     *     ),
     *     security={
     *          {"xsrf":{}}
     *     },
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = User::register(...$request->validated());
        return response()->json(
            ['user' => $user],
            Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     @OA\RequestBody (
     *         required=true,
     *         description="Login credentials",
     *         @OA\JsonContent(
     *              @OA\Property (
     *                  type="string",
     *                  property="name",
     *              ),
     *              @OA\Property(
     *                  type="string",
     *                  property="password",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged in",
     *          @OA\JsonContent(
     *              @OA\Property (property="success", type="string"),
     *              @OA\Property (property="user", ref="#/components/schemas/user"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *              @OA\Property (property="success", type="string"),
     *              @OA\Property (property="message", type="string"),
     *              @OA\Property (property="errors", type="object"),
     *          ),
     *     ),
     *     security={
     *          {"xsrf":{}, "session-id":{}}
     *     },
     * )
     */
    public function login(LoginRequest $request)
    {
        $user = User::where(['name' => $request->name])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong credentials',
                'errors' => ['Wrong login or password'],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Auth::guard('sanctum')->login($user);
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * @OA\Delete (
     *     path="/logout",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *     ),
     *     security={
     *          {"basicAuth":{}, "xsrf":{}, "session-id":{}}
     *     },
     * )
     */
    public function logout()
    {
        Auth::guard('sanctum')->logout();
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Getting current authenticated user",
     *          @OA\JsonContent(
     *              @OA\Property (property="user", ref="#/components/schemas/user"),
     *          ),
     *     ),
     *     security={
     *          {"basicAuth":{}, "xsrf":{}, "session-id":{}}
     *     },
     * )
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
