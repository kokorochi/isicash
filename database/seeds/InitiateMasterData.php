<?php

use Illuminate\Database\Seeder;

class InitiateMasterData extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Auth::create([
            'type'        => 'SU',
            'description' => 'Super User'
        ]);

        \App\Auth::create([
            'type'        => 'A',
            'description' => 'Admin'
        ]);

        \App\Auth::create([
            'type'        => 'U',
            'description' => 'User'
        ]);
    }
}
