<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\UserType;
class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->truncate();
        UserType::create([
            'id'          => '1',
            'user_type'         => 'Super Admin'
        ]);
        
        UserType::create([
            'id'          => '2',
            'user_type'         => 'Admin'
        ]);
    }
}
