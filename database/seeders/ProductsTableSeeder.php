<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('products')->count() == 0){

            $arr = [];
            for ($i=1; $i <= 20; $i++) { 

                $price = 100 + $i;
                $arr[] = [
                    'name' => 'Demo Product '.$i,
                    //'slug' => 'demo-item-'.$i,
                    //'sku' => 'sku'.$i,
                    'description' => 'This is the Demo Product '.$i,
                    'price' => $price,
                    //'sale_price' => '0',
                    'category_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            DB::table('products')->insert($arr);
            
        } else { echo "\e[31mTable is not empty, therefore NOT "; }
    }
}
