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
            CategoryTableSeeder::class
        ]);
        // factory(\App\Models\Book::class, 150)->create();
    }
}
