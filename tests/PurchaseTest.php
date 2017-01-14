<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\MGoods;
use App\Helper\JWTHelper;
use App\User;

class PurchaseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    private function createGoods(){
        // using be method will authenticate the test as a user
        $this->be(factory(App\User::class)->create());
        // using create method wills save the factory data to DB ;)
        $goods = factory(App\MGoods::class)->create();
    }

    public function testCreateGoods()
    {
        $user = factory(App\User::class)->create();
        $jwt = JWTHelper::encodeUser($user);
        $goods = factory(App\MGoods::class)->make()->toArray();;
        $cookies = [
            'token_id' => Crypt::encrypt($jwt)
        ];
        // to use cookie test must use method call https://laravel.com/api/5.2/Illuminate/Foundation/Testing/TestCase.html#method_call
        $req = $this->call('POST','/admin-api/barang',$goods,$cookies);
        $this->assertEquals(200,$req->status());

    }

    public function testPurchase(){
        var_dump($this->user);
    }
}
