<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        DB::table('users')
        ->insert([
            [
            'name' => 'Administrador',
            'email' => 'admin@peluquerianita.com',
            'password' => Hash::make('Adm1nP3lu'),
            'created_at' =>now(),
            'updated_at' =>now()
            ]
        ]);

    }
}
