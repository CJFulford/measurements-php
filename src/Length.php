<?php

namespace Cjfulford\Measurements;

class Length extends Measurement
{

    protected function __construct(float $value, Unit $unit, bool $isMutable = false)
    {
        parent::__construct(
            value    : $value,
            unit     : $unit,
            isMutable: $isMutable,
            unitClass: LengthUnit::class
        );
    }
}
