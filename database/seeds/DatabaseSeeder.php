<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AccountTypesTableSeeder::class,
            AccountsTableSeeder::class,
            // ItemsTableSeeder::class,
            VendorsTableSeeder::class,
            // CustomersTableSeeder::class,
            MarketplacesTableSeeder::class,
            UsersTableSeeder::class,
            ShippingServicesTableSeeder::class,
        ]);
    }
}
