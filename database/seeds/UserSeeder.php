<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	 
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'name'          => 'Super User',
            'email'         => 'admin@admin.com',
            'password'      => Hash::make('password'),
            'user_type_id'  => 1
        ]);
       
    }
}
