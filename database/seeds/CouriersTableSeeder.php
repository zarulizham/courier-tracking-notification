<?php

use Illuminate\Database\Seeder;
use App\Courier;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couriers = [
            [
                'name' => 'Poslaju',
            ], [
                'name' => 'DHL',
            ], [
                'name' => 'Skynet',
            ], [
                'name' => 'Ninja Van',
            ], [
                'name' => 'J&T Express',
            ],
        ];

        foreach ($couriers as $value) {
            Courier::updateOrCreate([
                'name' => $value['name'],
            ]);
        }
    }
}
