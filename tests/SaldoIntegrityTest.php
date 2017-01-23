<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\MCOA;
use Carbon\Carbon;
use App\Helper\JWTHelper;
class SaldoIntegrityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    public function testGeneralJournalUpdateAccountBalance()
    {
        $kasKecil = MCOA::find(1);
        $bankIDR = MCOA::find(4);
        $user = App\User::where('email','herujokoutomo@gmail.com')->first();
        $jwt = JWTHelper::encodeUser($user);
        $requestPayload = [
            'date' => '11/11/2016',
            'items' => [
                [
                    'mcoacode' => $kasKecil->mcoacode,
                    'debit' => 2000,
                    'credit' => 0,
                    'general_journal_detail_id' => str_random(8)
                ],
                [
                    'mcoacode' => $bankIDR->mcoacode,
                    'debit' => 0,
                    'credit' => 2000,
                    'general_journal_detail_id' => str_random(8)
                ]
            ]
        ];
        $cookies = [
            'token_id' => Crypt::encrypt($jwt)
        ];
        $req = $this->call('POST','/admin-api/generaljournal',$requestPayload,$cookies);
        $this->assertEquals(200,$req->status());
    }
}
