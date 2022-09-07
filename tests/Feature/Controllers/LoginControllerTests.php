<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTests extends TestCase
{
    /** @test */
    public function user_is_logged_in_successfully()
    {
        $user = $this->creatUser();

        $response = $this->json('post', 'api/login', [
            'name' => $user->name,
            'password' => 'password'
        ]);
        $response
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'created_at',
                    'email',
                    'name',
                    'updated_at'
                ]
            ]);
        $this->assertAuthenticated()
            ->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_failed_logging_in_with_wrong_credentials()
    {
        $response = $this->json('post', 'api/login', [
            'name' => 'wrong_name',
            'password' => 'wrong_password'
        ]);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => []
            ]);
        $this->assertGuest();
    }

    /** @test */
    public function user_registered_successfully()
    {
        $password = $this->faker()->word;
        $payload = [
            'name' => $this->faker()->name,
            'email' => $this->faker()->unique()->email,
            'password' => $password,
            'password_confirmation' => $password
        ];

        $response = $this->json('post', 'api/register', $payload);
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'user' => [
                    'created_at',
                    'email',
                    'id',
                    'name',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    /** @test */
    public function retrieve_user_successfully()
    {
        $user = $this->creatUser();
        $this->actingAs($user);

        $response = $this->json('get', 'api/user');
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'created_at',
                    'email',
                    'name',
                    'updated_at'
                ]
            ]);
    }

    /** @test */
    public function user_is_logged_out_successfully()
    {
        $user = $this->creatUser();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->json('delete', 'api/logout')
            ->assertStatus(Response::HTTP_OK);
        $this->assertGuest();
    }

    /** @test */
    public function dont_get_resource_when_not_authenticated()
    {
        $this->assertGuest();
        $response = $this->json('get', 'api/notes');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function has_validation_errors_when_providing_empty_fields()
    {
        $this->assertGuest();

        $response = $this->json('post', 'api/login', [
            'name' => '',
            'password' => ''
        ]);
        $response->assertJsonValidationErrors(['name', 'password']);
    }

    public function creatUser(): Authenticatable|Model|Collection
    {
        return User::factory()->create();
    }
}
