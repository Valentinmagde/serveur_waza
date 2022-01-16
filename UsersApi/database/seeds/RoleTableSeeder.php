<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'title' => 'Eleve'],
            ['id' => 2, 'title' => 'Parent'],
            ['id' => 3, 'title' => 'Administrateur'],
        ];
        DB::table('roles')->insert($roles);
    }
}
