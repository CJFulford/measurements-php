<?php

use Cjfulford\Measurements\Length;
use Cjfulford\Measurements\LengthUnit;

test('Invalid Length Creation', function () {
    new Length(1, 0);
})->throws(Exception::class);

function getRandom(): float
{
    return random_int(-100, 100) / (random_int(-100, 100) ?: 1);
}


foreach (array_keys(LengthUnit::getUnitDefinitions()) as $unitId) {
    $unit = new LengthUnit($unitId);

    $precision    = random_int(3, 10);
    $defaultValue = getRandom();

    test("{$unit->getName()} - Create length from ID", function () use ($defaultValue, $unitId) {
        // create from ID
        $length = new Length($defaultValue, $unitId);
        expect($length)->toBeInstanceOf(Length::class);
    });

    test("{$unit->getName()} - Create length from Object", function () use ($defaultValue, $unit) {
        $length = new Length($defaultValue, $unit);
        expect($length)->toBeInstanceOf(Length::class);
    });

    test(
        "{$unit->getName()} - Get original value in original units",
        function () use ($defaultValue, $unit, $precision) {
            $length = new Length($defaultValue, $unit);
            expect(round($length->getValue($unit), $precision))->toBe(round($defaultValue, $precision));
        }
    );

    test(
        "{$unit->getName()} - Compare equality of length to length",
        function () use ($defaultValue, $unit, $precision) {
            $length1 = new Length($defaultValue, $unit);
            $length2 = new Length($defaultValue, $unit);
            expect($length1->equals($length2, $precision))->toBeTrue();
        }
    );

    test(
        "{$unit->getName()} - Compare equality of length to length arguments",
        function () use ($defaultValue, $unit, $precision) {
            $length1 = new Length($defaultValue, $unit);
            expect($length1->equals($defaultValue, $unit->getId(), $precision))->toBeTrue();
        }
    );

    test("{$unit->getName()} - Add 2 lengths", function () use ($unit, $precision) {
        $value1      = getRandom();
        $value2      = getRandom();
        $resultValue = $value1 + $value2;

        $length1 = new Length($value1, $unit);
        $length2 = new Length($value2, $unit);

        $length1->add($length2);

        expect($length1->equals($resultValue, $unit, $precision))->toBeTrue();
    });

    test("{$unit->getName()} - Add length parameters", function () use ($unit) {
        $value1      = getRandom();
        $value2      = getRandom();
        $resultValue = $value1 + $value2;

        $length1 = new Length($value1, $unit);

        $length1->add($value2, $unit);

        expect($length1->equals($resultValue, $unit))->toBeTrue();
    });

    test("{$unit->getName()} - Subtract 2 lengths", function () use ($unit) {
        $value1      = getRandom();
        $value2      = getRandom();
        $resultValue = $value1 - $value2;

        $length1 = new Length($value1, $unit);
        $length2 = new Length($value2, $unit);

        $length1->sub($length2);

        expect($length1->equals($resultValue, $unit))->toBeTrue();
    });

    test("{$unit->getName()} - Subtract length parameters", function () use ($unit, $precision) {
        $value1      = getRandom();
        $value2      = getRandom();
        $resultValue = $value1 - $value2;

        $length1 = new Length($value1, $unit);

        $length1->sub($value2, $unit);

        expect($length1->equals($resultValue, $unit, $precision))->toBeTrue();
    });

    test("{$unit->getName()} - Mul by number", function () use ($unit, $precision) {
        $value1      = getRandom();
        $value2      = getRandom();
        $resultValue = $value1 * $value2;

        $length1 = new Length($value1, $unit);

        $length1->mulByNumber($value2);

        expect($length1->equals($resultValue, $unit, $precision))->toBeTrue();
    });

    test("{$unit->getName()} - Div by number", function () use ($unit, $precision) {
        $value1 = getRandom();
        do {
            $value2 = getRandom();
        } while ($value2 === 0.0);
        $resultValue = $value1 / $value2;

        $length1 = new Length($value1, $unit);

        $length1->divByNumber($value2);

        expect($length1->equals($resultValue, $unit, $precision))->toBeTrue();
    });
}
