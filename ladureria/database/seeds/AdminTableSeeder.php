<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder{

    public function run(){
        \DB::table('users')->insert(array(
            'first_name'          => 'Cooperativa',
            'last_name'          => 'Ferro',
            'email'         => 'info@coopfer.com',
            'password'      => \Hash::make('secret')
        ));
    }

}
