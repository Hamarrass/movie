<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
         $nbrUsers = (int)$this->command->ask("how many  of users you want generate ?",10);
        \App\Models\User::factory($nbrUsers)->create();
    }
}
