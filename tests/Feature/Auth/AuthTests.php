<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTests extends TestCase
{
    /** @test */
    public function user_is_logged_in_successfully()
    {
        // Arrange
        $user = $this->creatUser();
        $payload = [
            'name' => $user->name,
            'password' => 'password'
        ];

        // Act
        $response = $this->json(
            'post',
            route('login'),
            $payload
        );

        // Assert
        $response->assertJsonStructure([
            'user' => [
                'id',
                'created_at',
                'email',
                'name',
                'updated_at'
            ]
        ]);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_failed_logging_in_with_wrong_credentials()
    {
        $response = $this->json('post', route('login'), [
            'name' => 'wrong_name',
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
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

        $response = $this->json('post', route('register'), $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
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

        $response = $this->json('get', route('user'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
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
    public function dont_get_resource_when_not_authenticated()
    {
        $response = $this->json('get', route('notes.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function has_validation_errors_when_providing_empty_fields()
    {
        $response = $this->json('post', route('login'), [
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
