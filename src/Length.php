<?php

namespace Cjfulford\Measurements;

class Length extends Measurement
{

    public function __construct(float $value, Unit|int $unit)
    {
        parent::__construct(
            value    : $value,
            unit     : $unit,
            unitClass: LengthUnit::class
        );
    }
}
