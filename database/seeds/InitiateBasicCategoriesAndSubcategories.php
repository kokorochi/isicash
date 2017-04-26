<?php

use Illuminate\Database\Seeder;

class InitiateBasicCategoriesAndSubcategories extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = \App\Category::create([
            'category_code' => 'VG',
            'name'       => 'Voucher Game',
            'created_by' => 'admin',
        ]);

        $category->subCategory()->create([
            'sub_category_code' => 'WG',
            'name'       => 'Wave Game',
            'created_by' => 'admin',
        ]);

        $category->subCategory()->create([
            'sub_category_code' => 'GS',
            'name'       => 'Gemscool',
            'created_by' => 'admin',
        ]);

        $category->subCategory()->create([
            'sub_category_code' => 'GA',
            'name'       => 'Garena',
            'created_by' => 'admin',
        ]);
    }
}
