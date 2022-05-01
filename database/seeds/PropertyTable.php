<?php

use Illuminate\Database\Seeder;

class PropertyTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('properties')->insert([
            'name' => "Awesome house in the middle of my town",
            'address' => "Main street 17, 12456 Berlin",
            'propertyType' => "d44d0090-a2b5-47f7-80bb-d6e6f85fca90",
            'fields' => json_encode([
                'area' => '180',
                'yearOfConstruction' => '2010',
                'rooms' => '5',
                'heatingType' => 'gas',
                'parking' => true,
                'returnActual' => '12.8',
                'price' => '1500000'
            ])
        ]);
    }
}
