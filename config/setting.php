<?php

return [
    'limit' => 10,
    'seeder' => [
        'brands' => ['Iphone SE', 'Iphone SE (2020)'],
        'model_capacities' =>  array(
            'iphone-se' => array(
                array('name' => '2GB/16GB'),
                array('name' => '2GB/32GB'),
                array('name' => '2GB/32GB'),
                array('name' => '2GB/64GB'),
                array('name' => '2GB/128GB')
            ),
            'iphone-se-(2020)' => array(
                array('name' => '3GB/64GB')
            ),
        ),
        'products' => array(
            array(
                'type' => 'smartphone',
                'brand' => 'apple',
                'model' => 'iphone SE',
                'capacity' => '2GB/16GB',
                'quantity' => '13',
            ),
            array(
                'type' => 'smartphone',
                'brand' => 'apple',
                'model' => 'iphone SE',
                'capacity' => '2GB/32GB',
                'quantity' => '30',
            ),
            array(
                'type' => 'smartphone',
                'brand' => 'apple',
                'model' => 'iphone SE',
                'capacity' => '2GB/64GB',
                'quantity' => '20',
            ),
            array(
                'type' => 'smartphone',
                'brand' => 'apple',
                'model' => 'iphone SE',
                'capacity' => '2GB/128GB',
                'quantity' => '16',
            ),
            array(
                'type' => 'smartphone',
                'brand' => 'apple',
                'model' => 'iphone SE (2020)',
                'capacity' => '3GB/64GB',
                'quantity' => '18',
            ),
        )
    ],
];
