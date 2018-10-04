<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Gradient Admin', 'email' => 'admin@gradient.co.id', 'password' => Hash::make('virmata5515')]);
        User::create(['name' => 'Hadrian Lesmana', 'email' => 'hadrian.lesmana@gradient.co.id', 'password' => Hash::make('virmata5515')]);
        User::create(['name' => 'Dewi P. Sari', 'email' => 'dewi.sari@gradient.co.id', 'password' => Hash::make('virmata5515')]);
        User::create(['name' => 'Andreanto', 'email' => 'andreanto@gradient.co.id', 'password' => Hash::make('virmata5515')]);
        User::create(['name' => 'Robby Andreas', 'email' => 'robby.andreas@gradient.co.id', 'password' => Hash::make('virmata5515')]);
        User::create(['name' => 'Muari H. Shiddiqi', 'email' => 'muari.shiddiqi@gradient.co.id', 'password' => Hash::make('virmata5515')]);
    }
}
