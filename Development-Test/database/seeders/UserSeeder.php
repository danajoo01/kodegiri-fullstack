<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name'=>'admin',
            'email'=>'admin@test.com',
            'password'=> Hash::make('12345'),
            'no_hp'=>'089660222076',
            'company'=>'PT ABC',
            'divisi'=>'ABC',
            'foto'=>'',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
