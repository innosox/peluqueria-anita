<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')
        ->insert([
            [
                'name' => 'Corte de pelo Varon',
                'price_net' => '8.70',
                'price_iva' => '1.31',
                'price_subtotal' => '10.01',
                'price_total' => '10.01',
                'description' => 'Corte de pelo para varon',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'name' => 'Corte de pelo Mujer',
                'price_net' => '13.00',
                'price_iva' => '1.95',
                'price_subtotal' => '14.95',
                'price_total' => '14.95',
                'description' => 'Corte de pelo para mujer',
                'created_at' =>now(),
                'updated_at' =>now()
            ],
            [
                'name' => 'Manicure Mujer',
                'price_net' => '15.00',
                'price_iva' => '2.25',
                'price_subtotal' => '17.25',
                'price_total' => '17.25',
                'description' => 'Manicure para mujer',
                'created_at' =>now(),
                'updated_at' =>now()
            ]
        ]);
    }
}
