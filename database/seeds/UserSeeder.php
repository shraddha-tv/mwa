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

        DB::table('users')->insert([
            [
                'name' => "Admin",
                'email' => 'admin@smn.lk',
                'password' => Hash::make('Admin$321'),
                'state_id' => 1,
                'create_by' => 1,

            ],
        ]);
        DB::table('locations')->insert([
            [
                'address' => "pending",
                'district' => "pending",
                'province' => "pending",
                'gs_division' => "pending",
                'latitude' => "12.5",
                'longitude' => "34.6",
                'divisional_secretariat' => "pending",
                'user_id' => 1,
            ],
        ]);
    }
}
