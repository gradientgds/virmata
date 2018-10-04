<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Accounting\AccountType;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Aktiva Lancar
        AccountType::create(['name' => 'Kas/Bank']); // #1
        AccountType::create(['name' => 'Piutang Dagang']); // #2
        AccountType::create(['name' => 'Persediaan Barang']); // #3
        AccountType::create(['name' => 'Aktiva Lancar Lainya']); // #4

        // Aktiva Tetap
        AccountType::create(['name' => 'Aktiva Tetap']); // #5
        AccountType::create(['name' => 'Akumulasi Penyusutan']); // #6
        AccountType::create(['name' => 'Aktiva Tetap Lainya']); // #7

        // Hutang Lancar
        AccountType::create(['name' => 'Hutang Dagang']); // #8
        AccountType::create(['name' => 'Hutang Lancar Lainya']); // #9

        // Hutang Jangka Panjang
        AccountType::create(['name' => 'Hutang Jangka Panjang']); // #10

        // Equitas
        AccountType::create(['name' => 'Equitas']); // #11

        // Pendapatan Usaha
        AccountType::create(['name' => 'Pendapatan Usaha']); // #12
        AccountType::create(['name' => 'Harga Pokok Penjualan']); // #13
        AccountType::create(['name' => 'Beban Usaha']); // #14
        
        // Pendapatan Lain-lain
        AccountType::create(['name' => 'Pendapatan Lain-lain']); // #15
        AccountType::create(['name' => 'Beban Lain-lain']); // #16
    }
}
