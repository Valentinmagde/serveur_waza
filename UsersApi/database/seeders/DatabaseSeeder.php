<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
            ClassTableSeeder::class,
            SchoolTableSeeder::class
        ]);
        // factory(\App\Models\Author::class, 50)->create();
    }
}
