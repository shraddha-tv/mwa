<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            [
                'name' => "pending",
            ],
        ]);

        DB::table('locations')->insert([
            [
                'address' => "pending",
                'district' => "pending",
                'province' => "pending",
                'grama_niladari_wasama' => "pending",
                'divisional_secretariat' => "pending",
            ],
        ]);

        DB::table('users')->insert([
            [
                'name' => "Admin",
                'email' => 'admin@smn.lk',
                'password' => Hash::make('Admin$321'),
                'state_id' => 1,
                'location_id' => 1,

            ],
        ]);
    }
}
