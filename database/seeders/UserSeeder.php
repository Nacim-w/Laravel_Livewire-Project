<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role_id' => '1',
        ]);
        DB::table('users')->insert([
            'username' => 'Test',
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test'),
            'role_id' => '2',
        ]);
    }
}
