<?php

// Shipments are measured in kilograms
// 10000000000000000 refer to infinity
// by ton
return [
        'dyna' => ['min' => 5 , 'max' => 9.99],
        'lorry' => ['min' => 10 , 'max' => 23.99],
        'truck' => ['min' => 24 , 'max' => 10000000000000000],
];