<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('products')->insert([
            'name' => 'product1',
            'price' => '20000',
            'stock' => 0,

        ]);
        DB::table('products')->insert([
            'name' => 'product2',
            'price' => '30000',
            'stock' => 4,

        ]);
        DB::table('products')->insert([
            'name' => 'product3',
            'price' => '10000',
            'stock' => 1,

        ]);
    }
}
