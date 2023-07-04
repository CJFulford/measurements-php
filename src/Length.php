<?php

namespace Cjfulford\Measurements;

class Length extends Measurement
{

    public function __construct(float $value, Unit|int $unit, bool $isMutable = false)
    {
        parent::__construct(
            value    : $value,
            unit     : $unit,
            isMutable: $isMutable,
            unitClass: LengthUnit::class
        );
    }
}
