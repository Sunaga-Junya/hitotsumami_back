<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'キャベツ',
                'unit' => '個',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ingredients')->insert($data);
    }
}
