<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert( [
            [
                'name' => 'Administrador',
                'last_name' => 'General',
                'email' => 'administrador@gmail.com',
                'document' => '1',
                'phone_number' => "3111111111",
                'size_organization' => "",
                'name_organization' => "",
                'password' => bcrypt('123456Abc!'),
                'confirmation_code' =>  hash('sha256', "administrador@gmail.com"),
                'rol_id' => 1,
            ],
            [
                'name' => 'Usuaurio',
                'last_name' => 'Prueba',
                'email' => 'correo@gmail.com',
                'document' => '2',
                'phone_number' => "3111111111",
                'size_organization' => "",
                'name_organization' => "",
                'password' => bcrypt('123456Abc!'),
                'confirmation_code' =>  hash('sha256', "correo@gmail.com"),
                'rol_id' => 2,
            ],
        ]);
    }
}
