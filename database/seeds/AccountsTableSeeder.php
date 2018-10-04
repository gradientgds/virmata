<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Accounting\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // # 1 - ACCOUNT PAYABLE
        // Account::create([
        // 	'number' => '2101.02',
        //     'name' => 'Account Payable IDR',
        //     'account_type_id' => 8,
        // ]);

        // # 2 - ACCOUNT RECEIVABLE
        // Account::create([
        // 	'number' => '1103.02',
        //     'name' => 'Account Receivable IDR',
        //     'account_type_id' => 2,
        // ]);

        // # 3 - Inventory / Persediaan Barang
        // Account::create([
        // 	'number' => '1200',
        //     'name' => 'Persediaan Barang',
        //     'account_type_id' => 3,
        // ]);

        // # 4 - COGS / HPP
        // Account::create([
        // 	'number' => '5000.01',
        //     'name' => 'HPP',
        //     'account_type_id' => 13,
        // ]);

        // # 5 - Product Sales Revenue / Pendapatan Penjualan Barang
        // Account::create([
        // 	'number' => '4000.01',
        //     'name' => 'Pendapatan Penjualan Barang',
        //     'account_type_id' => 12,
        // ]);

        // # 6 - Product Sales Discount / Potongan Penjualan Barang
        // Account::create([
        // 	'number' => '4000.02',
        //     'name' => 'Potongan Penjualan Barang',
        //     'account_type_id' => 12,
        // ]);

        // # 7 - Product Sales Return / Retur Penjualan Barang
        // Account::create([
        // 	'number' => '4000.03',
        //     'name' => 'Retur Penjualan Barang',
        //     'account_type_id' => 12,
        // ]);
        
        // # 8 - PPN Masukan
        // Account::create([
        // 	'number' => '1600',
        //     'name' => 'PPN Masukan',
        //     'account_type_id' => 4,
        // ]);

        // # 9 - PPN Keluaran
        // Account::create([
        // 	'number' => '2100',
        //     'name' => 'PPN Keluaran',
        //     'account_type_id' => 9,
        // ]);

        // # 10 - Pendapatan Biaya Kirim
        // Account::create([
        // 	'number' => '7100.01',
        //     'name' => 'Pendapatan Biaya Kirim',
        //     'account_type_id' => 15,
        // ]);

        Account::create(['number' => 1, 'name' => 'Biaya Kirim Penjualan Online', 'account_type_id' => 16]);
        Account::create(['number' => 2, 'name' => 'Biaya Asuransi Penjualan Online', 'account_type_id' => 16]);
        Account::create(['number' => 3, 'name' => 'Biaya Lain-lain Penjualan Online', 'account_type_id' => 16]);
    }
}
