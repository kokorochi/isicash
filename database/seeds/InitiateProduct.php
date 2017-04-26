<?php

use Illuminate\Database\Seeder;

class InitiateProduct extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $product = \App\Product::create([
            'category_code'     => 'VG', //Voucher Game
            'sub_category_code' => 'WG', //Wave Game
            'product_code'      => 'WG-250',
            'name'              => 'Voucher Wave Game 250.000',
            'description'       => 'Voucher Wave Game seharga Rp.250.000,-',
            'image_file'        => 'wavegame250-qweasd.jpg',
            'created_by'        => 'admin'
        ]);

        $product->productPrice()->create([
            'date'           => '2017-04-01',
            'purchase_price' => '216500.00',
            'sales_price'    => '220000.00',
            'discount'       => '0',
            'final_price'    => '220000.00',
            'created_by'     => 'admin',
        ]);

        $product = \App\Product::create([
            'category_code'     => 'VG', //Voucher Game
            'sub_category_code' => 'GS', //Gemscool
            'product_code'      => 'GS-300',
            'name'              => 'Voucher Gemscool 300.000',
            'description'       => 'Voucher Gemscool seharga Rp.300.000,-',
            'image_file'        => 'gemscool300-qweasd.jpg',
            'created_by'        => 'admin'
        ]);

        $product->productPrice()->create([
            'date'           => '2017-04-01',
            'purchase_price' => '250000.00',
            'sales_price'    => '270000.00',
            'discount'       => '0',
            'final_price'    => '270000.00',
            'created_by'     => 'admin',
        ]);

        $product = \App\Product::create([
            'category_code'     => 'VG', //Voucher Game
            'sub_category_code' => 'GA', //Garena
            'product_code'      => 'GA-100',
            'name'              => 'Voucher Garena 100.000',
            'description'       => 'Voucher Garena seharga Rp.100.000,-',
            'image_file'        => 'garena100-qweasd.jpg',
            'created_by'        => 'admin'
        ]);

        $product->productPrice()->create([
            'date'           => '2017-04-01',
            'purchase_price' => '80000.00',
            'sales_price'    => '90000.00',
            'discount'       => '0',
            'final_price'    => '90000.00',
            'created_by'     => 'admin',
        ]);
    }
}
