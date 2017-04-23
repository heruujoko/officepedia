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

class PurchaseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    private $user;

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
        // $this->user = $user;
    }

    public function testPurchase(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
    }

    public function testPurchaseAddStock(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
      $stock_card = MStockCard::where('mstockcardgoodsid',$goods['mgoodscode'])->first();
      $this->assertEquals(144,$stock_card->mstockcardstockin);
      $this->assertEquals(0,$stock_card->mstockcardstockout);
    }

    public function testTwicePurchaseAddStock(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 5,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
      $req2 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);
      $stock_card = MStockCard::where('mstockcardgoodsid',$goods['mgoodscode'])->get()->last();

      $this->assertEquals(288,$stock_card->mstockcardstocktotal);
      $this->assertEquals(0,$stock_card->mstockcardstockout);
    }

    public function testTwicePurchaseAddStockInWarehouse(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 0,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 5,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
      $req2 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);

      $warehouse_stock = MGoodsWarehouse::where('mgoodscode',$goods['mgoodscode'])->where('mwarehouseid',1)->first();
      $this->assertEquals(288,$warehouse_stock->stock);

    }

    public function testDeletePurchase(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
      $g = MHPurchase::all();
      $req2 = $this->call('DELETE','/admin-api/purchaseinvoice/'.$g[0]->id,$purchase_data,$cookies);
      $this->assertEquals(200,$req2->status());

    }

    public function testDeletePurchaseReduceStockAndAlsoInWarehouse(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 100000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 80000,
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
      $g = MHPurchase::all();
      $req2 = $this->call('DELETE','/admin-api/purchaseinvoice/'.$g[0]->id,$purchase_data,$cookies);

      $stock_card = MStockCard::where('mstockcardgoodsid',$goods['mgoodscode'])->get()->last();
      $this->assertEquals(144,$stock_card->mstockcardstockout);

      $warehouse_stock = MGoodsWarehouse::where('mgoodscode',$goods['mgoodscode'])->get()->last();
      $this->assertEquals(0,$warehouse_stock->stock);

    }

    public function testPurchaseCreatingCOGS(){
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
        'date' => Carbon::now(),
        'duedate' => Carbon::now()->addDays(12),
        'subtotal' => 11520000,
        'discount' => 0,
        'tax' => 0,
        'goods' => [
            [
                'id' => 1,
                'detail_goods_unit3' => 1,
                'detail_goods_unit3_conv' => 144,
                'detail_goods_unit3_label' => 'Karton',
                'detail_goods_unit2' => 0,
                'detail_goods_unit2_conv' => 12,
                'detail_goods_unit2_label' => 'Lusin',
                'detail_goods_unit1' => 0,
                'detail_goods_unit1_conv' => 1,
                'detail_goods_unit1_label' => 'Unit',
                'usage' => 144,
                'usage_label' => '',
                'buy_price' => 80000,
                'disc' => 0,
                'subtotal' => 11520000,
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

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->where('branchid','BRN000001')->first();
      // cogs pertama 80K
      $this->assertEquals(80000,$cogs->mcogslastcogs);
    }

    public function testPurchaseCreatingCOGSTwoTransaction(){
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
        'date' => Carbon::now(),
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
        'date' => Carbon::now(),
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
      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->where('branchid','BRN000001')->first();
      // cogs pertama 80K
      // $this->assertEquals(80000,$cogs->mcogslastcogs);
      $this->assertEquals(80000,$cogs->mcogslastcogs);
      $req2 = $this->call('POST','/admin-api/purchaseinvoice',$purchase_data2,$cookies);

      $cogs = MCOGS::where('mcogsgoodscode',$goods['mgoodscode'])->where('branchid','BRN000001')->first();
      // cogs pertama 80K
      $this->assertEquals(81500,$cogs->mcogslastcogs);
    }
}
