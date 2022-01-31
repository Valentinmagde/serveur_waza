<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            ['id' => 1, 'name' => 'Lycée Félix Eboué'],
            ['id' => 2, 'name' => 'Lycée de la Liberté']
        ];
        DB::table('schools')->insert($classes);
    }
}
