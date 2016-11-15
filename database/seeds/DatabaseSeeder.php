<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MCOAFullSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(MGoodsCategorySeed::class);
        $this->call(MGoodsMarkSeeder::class);
        $this->call(MGoodsUnitSeeder::class);
        $this->call(MGoodsTypeSeeder::class);
        $this->call(DefaultSupplierSeeder::class);
        $this->call(mcategorycustomertableseeder::class);
        $this->call(MWarehouseSeeder::class);
    }
}
