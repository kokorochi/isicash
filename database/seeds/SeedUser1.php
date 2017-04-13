<?php

use Illuminate\Database\Seeder;

class SeedUser1 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        $user->userAccount()->create([
            'email'     => 'kokorochi.zhou@gmail.com',
            'full_name' => 'Surya Wijaya',
            'phone'     => '081292123',
            'dob'       => '9999-12-12',
            'sex'       => 'laki-laki',
            'verified'  => '1',
            'pin'       => '123456',
            'balance'   => 100000
        ]);
        
        $user->userAuth()->create([
            'auth_type' => 'A',
        ]);

        $user = \App\User::create([
            'username' => 'user_1',
            'password' => bcrypt('user')
        ]);

        $user->userAccount()->create([
            'email'     => 'kokorochi.zhou@gmail.com',
            'full_name' => 'User Wijaya',
            'phone'     => '081292123',
            'dob'       => '9999-12-12',
            'sex'       => 'laki-laki',
            'verified'  => '1',
            'pin'       => '123456',
            'balance'   => 100000
        ]);
    }
}
