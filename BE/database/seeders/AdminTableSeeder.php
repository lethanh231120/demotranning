<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //    \App\Models\User::factory(10)->create();
        DB::table('admins')->insert([
            'email' => 'lethanh231120@gmail.com',
            'user_name' => 'admin',
            'birthday' => '2000-01-01',
            'first_name' => 'ad',
            'last_name' => 'min',
            'password' => bcrypt('123456'),
            'reset_password' => bcrypt('123456'),
            'status' => 1,
        ]);
    }
}
