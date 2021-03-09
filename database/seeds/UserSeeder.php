<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'id' => 2,
            'first_name' => 'Avem',
            'last_name' => 'Administrator',
            'email' => 'avem@gmail.com',
            'password' => Hash::make('Kad1Ch'),
            'birth' => '2007-07-07',
            'city_id' => 109897,
            'status' => 'Creator of the Avem',
            'description' => 'The group of 3 creators of the avem: Ilyas Kadyrbekov, Vladyslav Firstenko, Denys Churchyn',
        ]);
        $last_id = DB::table('users')->max('id');
        DB::table('role_user')->insert([
            'user_id' => $last_id,
            'role_id' => 1
        ]);
    }
}
// php artisan db:seed --class=UserSeeder
