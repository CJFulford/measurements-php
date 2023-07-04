<?php

use Cjfulford\Measurements\Length;
use Cjfulford\Measurements\LengthUnit;

test('Invalid Length Creation', function () {
    new Length(1, 0);
})->throws(Exception::class);

test('Creation of a Length for each unit', function () {
    $unitIds = [
        LengthUnit::IN,
        LengthUnit::FT,
    ];

    $defaultValue = 10.0;

    foreach ($unitIds as $unitId) {
        // create from ID
        $length = new Length($defaultValue, $unitId);
        expect($length)->toBeInstanceOf(Length::class);

        // create from object
        $unit   = new LengthUnit($unitId);
        $length = new Length($defaultValue, $unit);
        expect($length)->toBeInstanceOf(Length::class);

        // after creation, getting the original value in the original units is
        expect($length->getValue($unit))->toBe($defaultValue);
    }
});
