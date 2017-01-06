<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    private function createUser($user){
        $usr = new User;
        $usr->name = $user->name;
        $usr->password = $user->password;
        $usr->email = $user->email;
        $usr->db_alias = $user->db_alias;
        $usr->db_name = $user->db_name;
        $usr->remember_token = $user->remember_token;
        $usr->save();
    }

    public function testLoginGiveAuthTokenInCookie()
    {
        $user = factory(App\User::class)->make();
        $this->createUser($user);
        $this->post('/login',['email' => $user->email,'password' => "12345"])
        ->assertRedirectedTo('http://officepedia.dev/admin-nano/index')
        ->seeCookie('token_id');
    }
}
