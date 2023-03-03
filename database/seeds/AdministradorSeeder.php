<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user_id = DB::table('users')->where('name','Prograd')->pluck('id');

      DB::table('administradors')->insert([
        'matricula'=>'234567890',
        'user_id' => $user_id[0],
      ]);

      // $user_id = DB::table('users')->where('name','Administrador')->pluck('id');

      // DB::table('administradors')->insert([
      //   'matricula'=>'123456789',
      //   'user_id' => $user_id[0],
      // ]);

      // $user_id = DB::table('users')->where('name','Lucas Henrique (ADM)')->pluck('id');
      // DB::table('administradors')->insert([
      //   'matricula'=>'012345678',
      //   'user_id' => $user_id[0],
      // ]);
    }
}
