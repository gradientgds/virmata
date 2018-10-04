<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Sales\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create(['name' => 'Customer A', 'phone' => '0813', 'address_raw' => '']);
    }
}
