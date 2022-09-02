<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('customers')->count() == 0){

            $arr = [];
            for ($i=1; $i <= 50; $i++) { 
                $arr[] = [
                    'name' => 'Customer '.$i,
                    'address' => 'demo address '.$i,
                    'mobile' => '112233445'.$i,
                    'email' => 'demo'.$i.'@gmail.com',
                    'pan_no' => $i,
                    'aadhar_no' => $i,
                    'gst_no' => $i,
                    'sales_persone_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            DB::table('customers')->insert($arr);
            
        } else { echo "\e[31mTable is not empty, therefore NOT "; }
    }
}
