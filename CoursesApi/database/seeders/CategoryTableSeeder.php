<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'title' => 'Mathématiques'],
            ['id' => 2, 'title' => 'Physique'],
            ['id' => 3, 'title' => 'Chimie'],
            ['id' => 4, 'title' => 'Biologie'],
            ['id' => 5, 'title' => 'Français'],
            ['id' => 6, 'title' => 'Anglais']
        ];
        DB::table('categories')->insert($categories);
    }
}
