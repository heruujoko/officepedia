<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\MGoods;
use App\Helper\JWTHelper;
use App\User;
use Carbon\Carbon;
use App\MStockCard;
use App\MGoodsWarehouse;
use App\MHPurchase;
use App\MCOGS;
use App\HPPHistory;

class COGSTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    private $user;

    public function testCogsPurchaseOne(){

      // purchase one

      $user = factory(App\User::class)->create();
      $jwt = JWTHelper::encodeUser($user);
      $goods = factory(App\MGoods::class)->make()->toArray();;
      $cookies = [
          'token_id' => Crypt::encrypt($jwt)
      ];

      $req = $this->call('POST','/admin-api/barang',$goods,$cookies);

      $purchase_data = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4000000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 4000000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];
      $req = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data,$cookies);

      $this->assertEquals(200,$req->status());

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->first();

      $this->assertEquals(80000,$cogs->mcogslastcogs);
    }

    public function testCogsPurchaseTwo(){

      // purchase one

      $user = factory(App\User::class)->create();
      $jwt = JWTHelper::encodeUser($user);
      $goods = factory(App\MGoods::class)->make()->toArray();;
      $cookies = [
          'token_id' => Crypt::encrypt($jwt)
      ];

      $req = $this->call('POST','/admin-api/barang',$goods,$cookies);

      $purchase_data = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4000000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 4000000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $purchase_data2 = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4150000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 83000,
                'disc' => 0,
                'subtotal' => 4150000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $req = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data,$cookies);

      $this->assertEquals(200,$req->status());

      $req = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);

      $this->assertEquals(200,$req->status());

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->first();

      $this->assertEquals(81500,$cogs->mcogslastcogs);
    }

    public function testCogsPurchaseTwoAndOneFromYesterday(){

      // purchase one

      $user = factory(App\User::class)->create();
      $jwt = JWTHelper::encodeUser($user);
      $goods = factory(App\MGoods::class)->make()->toArray();;
      $cookies = [
          'token_id' => Crypt::encrypt($jwt)
      ];

      $req = $this->call('POST','/admin-api/barang',$goods,$cookies);

      $purchase_data = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4000000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 4000000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $purchase_data2 = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4150000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 83000,
                'disc' => 0,
                'subtotal' => 4150000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $purchase_data3 = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-20'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 6640000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 80,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 80,
                'usage_label' => '',
                'buy_price' => 83000,
                'disc' => 0,
                'subtotal' => 6640000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $req = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data,$cookies);

      $this->assertEquals(200,$req->status());

      sleep(1);

      $req2 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);

      $this->assertEquals(200,$req2->status());

      sleep(1);

      $req3 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data3,$cookies);

      $this->assertEquals(200,$req3->status());

      $histories = HPPHistory::all();

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->first();
      $rounded = round(floatval($cogs->mcogslastcogs),2);
      $this->assertEquals(82166.66,$rounded);
    }

    public function testCogsPurchaseAndSellOne(){

      // purchase one

      $user = factory(App\User::class)->create();
      $customer = factory(App\MCustomer::class)->make()->toArray();
      $jwt = JWTHelper::encodeUser($user);
      $goods = factory(App\MGoods::class)->make()->toArray();;
      $cookies = [
          'token_id' => Crypt::encrypt($jwt)
      ];

      $req = $this->call('POST','/admin-api/barang',$goods,$cookies);
      $req = $this->call('POST','/admin-api/pelanggan',$customer,$cookies);

      $purchase_data = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4000000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 4000000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $purchase_data2 = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-23'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 4150000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 50,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 50,
                'usage_label' => '',
                'buy_price' => 83000,
                'disc' => 0,
                'subtotal' => 4150000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $purchase_data3 = [
        'do' => 'ORDER 1',
        'order' => 'ORD',
        'date' => Carbon::parse('2017-04-20'),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 6640000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 80,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 80,
                'usage_label' => '',
                'buy_price' => 83000,
                'disc' => 0,
                'subtotal' => 6640000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
        ],
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'type' => 'Pembelian',
        'no' => '',
        'autogen' => true
      ];

      $invoice_data = [
          'date' => Carbon::parse('2017-04-20'),
          'duedate' => Carbon::parse('2017-04-20')->addDays(14),
          'subtotal' => 4500000,
          'tax' => 0,
          'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 45,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 45,
                'usage_label' => '',
                'sell_price' => 100000,
                'disc' => 0,
                'subtotal' => 4500000,
                'goods' => $goods,
                'tax' => 0,
                'warehouse' => 1,
                'saved_unit' => 0,
                'remark' => ''
            ]
          ],
          'mcustomerid' => 'CUS001',
          'mcustomername' => 'Dilo',
          'type' => 'Penjualan',
          'no' => '',
          'autogen' => true
      ];

      $req = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data,$cookies);

      $this->assertEquals(200,$req->status());

      sleep(1);

      $req2 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);

      $this->assertEquals(200,$req2->status());

      sleep(1);

      $req3 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data3,$cookies);

      $this->assertEquals(200,$req3->status());

      $req4 = $this->call('POST','/admin-api/salesinvoice',$invoice_data,$cookies);

      $this->assertEquals(200,$req4->status());

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->first();
      $rounded = round(floatval($cogs->mcogslastcogs),2);
      $this->assertEquals(82166.66,$rounded);
    }
}
