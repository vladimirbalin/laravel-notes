<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
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
     *                  property="username",
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
    public function login(Request $request)
    {
        $user = User::where(['name' => $request->username])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong credentials',
                'errors' => ['Wrong login or password'],
            ], 422);
        }

        Auth::guard('sanctum')->login($user);
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     @OA\RequestBody (
     *         required=true,
     *         description="Registration credentials",
     *         @OA\JsonContent(
     *              @OA\Property (type="string", property="username"),
     *              @OA\Property (type="string", property="email", format="email"),
     *              @OA\Property (type="string", property="password"),
     *              @OA\Property (type="string", property="password_confirmation"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully registered",
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
     *          {"xsrf":{}}
     *     },
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'errors' => $validator->getMessageBag()->all()
            ], 422);
        }

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Getting current authenticated user",
     *          @OA\JsonContent(
     *              @OA\Property (property="success", type="string"),
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
        return response()->json($request->user());
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
}
