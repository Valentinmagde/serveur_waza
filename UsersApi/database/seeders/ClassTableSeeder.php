<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            ['id' => 1, 'title' => '3e', 'description' => 'Troisième'],
            ['id' => 2, 'title' => 'Tle', 'description' => 'Terminale']
        ];
        DB::table('classes')->insert($classes);
    }
}
