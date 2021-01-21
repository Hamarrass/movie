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
        // $this->call('UsersTableSeeder');
        /*to do  that excute this command
        php artisan db:seed
        */
        if($this->command->confirm("do you want to refresh the database", true)){
            $this->command->call("migrate:refresh");
            $this->command->info("database was refreshed!");
        }
        $this->call([
                   UsersTableSeeder::class
                   ]);
    }
}
