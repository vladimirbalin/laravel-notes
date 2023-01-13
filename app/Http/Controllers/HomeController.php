<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

/**
 * @OA\Get (
 *     path="/sanctum/csrf-cookie",
 *     @OA\Response(
 *          response="204",
 *          description="The CSRF token is returned in a cookie named `XSRF-TOKEN`. You need to include this cookie in subsequent requests.",
 *          @OA\Parameter(
 *              in="headers",
 *              name="Set-cookie",
 *          )
 *     )
 * )
 */

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *     ),
     *     @OA\Response(response="200",
     *         description="homepage of an API",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'name' => Session::token()
        ]);
    }
}
