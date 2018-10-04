<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Purchase\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create(['name' => 'Vendor X', 'phone' => '081296353558']);
        Vendor::create(['name' => 'Pajak Negara ID', 'phone' => '081296353558']);
        Vendor::create(['name' => 'A. Hartrodt ID', 'phone' => '081296353558']);
        Vendor::create(['name' => 'Pelita Harapan', 'phone' => '081296353558']);
        Vendor::create(['name' => 'Tokopedia', 'phone' => '081296353558']);
    }
}
