<?php

use Illuminate\Database\Seeder;

class Seed10Voucher extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $product = \App\Product::find(1);
        for ($i = 0; $i < 1000; $i++)
        {
            $product->voucher()->create([
                'code'       => encrypt(strtoupper(str_random(16))),
                'used'       => false,
                'created_by' => 'admin',
            ]);
        }

        $product = \App\Product::find(2);
        for ($i = 0; $i < 1000; $i++)
        {
            $product->voucher()->create([
                'code'       => encrypt(strtoupper(str_random(16))),
                'used'       => false,
                'created_by' => 'admin',
            ]);
        }

        $product = \App\Product::find(3);
        for ($i = 0; $i < 1000; $i++)
        {
            $product->voucher()->create([
                'code'       => encrypt(strtoupper(str_random(16))),
                'used'       => false,
                'created_by' => 'admin',
            ]);
        }
    }
}
