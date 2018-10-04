<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Purchase\Vendor;
use App\Models\ShippingService;

class ShippingServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingService::create(['name' => 'Pick-Up', 'vendor_id' => 0]);

        $vendor = Vendor::create(['name' => 'JNE', 'phone' => '081296353558']);
        ShippingService::create(['name' => 'JNE REG', 'vendor_id' => $vendor->id]);
        ShippingService::create(['name' => 'JNE YES', 'vendor_id' => $vendor->id]);

        $vendor = Vendor::create(['name' => 'JNT', 'phone' => '081296353558']);
        ShippingService::create(['name' => 'JNT Reguler', 'vendor_id' => $vendor->id]);

        $vendor = Vendor::create(['name' => 'GOJEK', 'phone' => '081296353558']);
        ShippingService::create(['name' => 'Go-Send Same Day', 'vendor_id' => $vendor->id]);
        ShippingService::create(['name' => 'Go-Send Instant Courier', 'vendor_id' => $vendor->id]);

        $vendor = Vendor::create(['name' => 'Grab', 'phone' => '081296353558']);
        ShippingService::create(['name' => 'Grab Instant', 'vendor_id' => $vendor->id]);
    }
}
