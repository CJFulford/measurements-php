<?php

use Cjfulford\Measurements\Length;
use Cjfulford\Measurements\LengthUnit;

test('Invalid Length Creation', function () {
    new Length(1, 0);
})->throws(Exception::class);

$unitIds = [
    // Imperial
    LengthUnit::TWIP,
    LengthUnit::THOU,
    LengthUnit::BARLEYCORN,
    LengthUnit::INCH,
    LengthUnit::HAND,
    LengthUnit::FOOT,
    LengthUnit::YARD,
    LengthUnit::CHAIN,
    LengthUnit::FURLONG,
    LengthUnit::MILE,
    LengthUnit::LEAGUE,
    LengthUnit::FATHOM,
    LengthUnit::CABLE,
    LengthUnit::NAUTICAL_MILE,
];

$defaultValue = 10.0;

foreach ($unitIds as $unitId) {
    $unit = new LengthUnit($unitId);

    test('Creation of lengths for ' . $unit->getName(), function () use ($defaultValue, $unitId, $unit) {
        // create from ID
        $length = new Length($defaultValue, $unitId);
        expect($length)->toBeInstanceOf(Length::class);

        // create from object
        $unit   = new LengthUnit($unitId);
        $length = new Length($defaultValue, $unit);
        expect($length)->toBeInstanceOf(Length::class);

        // after creation, getting the original value in the original units is
        expect($length->getValue($unit))->toBe($defaultValue);
    });
}
