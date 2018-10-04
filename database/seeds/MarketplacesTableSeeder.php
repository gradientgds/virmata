<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Marketplace;

class MarketplacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marketplace::create(['name' => 'COD']);
        Marketplace::create(['name' => 'Tokopedia']);
        Marketplace::create(['name' => 'Bukalapak']);
        Marketplace::create(['name' => 'Shopee']);
    }
}
