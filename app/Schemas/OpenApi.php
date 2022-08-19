<?php

namespace App\Schemas;

/**
 * @OA\Info(
 *      title="Laravel-notes API",
 *      version="1.0.0",
 *      @OA\Contact(
 *        email="support@example.com"
 *     )
 * ),
 * @OA\Server (
 *      url="https://notes-api.vladimirbalin.ru/api/",
 * )
 * @OA\SecurityScheme(
 *      securityScheme="xsrf",
 *      type="apiKey",
 *      in="cookie",
 *      name="XSRF-TOKEN"
 * ),
 * @OA\SecurityScheme(
 *      securityScheme="session-id",
 *      type="apiKey",
 *      in="cookie",
 *      name="notes_laravel_session"
 * ),
 * @OA\Schema(
 *      schema="note-resource",
 *      title="Note resource",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 * )
 * @OA\Schema(
 *      title="User model",
 *      schema="user",
 *      @OA\Property(property="id", type="integer",),
 *      @OA\Property(property="name", type="string",),
 *      @OA\Property(property="email", type="string", format="email"),
 *      @OA\Property(property="email_verified_at", type="string", format="date-time",),
 *      @OA\Property(property="created_at", type="string", format="date-time",),
 *      @OA\Property(property="updated_at", type="string", format="date-time",),
 * )
 */
class OpenApi{}
