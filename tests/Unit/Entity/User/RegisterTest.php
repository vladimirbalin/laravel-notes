<?php

namespace Entity\User;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function user_register()
    {
        $user = User::register(
            $name = 'name',
            $email = 'email@email.com',
            $password = 'password'
        );

        $this->assertNotEmpty($user);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);

        $this->assertNotEmpty($user->password);
        $this->assertNotEquals($password, $user->password);
    }
}
