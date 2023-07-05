<?php

namespace Cjfulford\Measurements;

use Exception;

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

    /**
     * A length divided by a length causes the units to cancel out and therefore this returns a number
     *
     * @param Length|float $value
     * @param LengthUnit|int|null $unit
     * @return float
     * @throws Exception
     */
    public function divByLength(Length|float $value, LengthUnit|int|null $unit = null): float
    {
        if ($value instanceof Length) {
            return $this->value / $value->value;
        }

        if ($unit === null) {
            throw new Exception('No unit provided');
        }

        // ensure that $unit is a LengthUnit
        $unit = $unit instanceof $this->unitClass ? $unit : new $this->unitClass($unit);
        // recurse on this function now that the argument is a Length
        return $this->divByLength(new self($value, $unit));
    }
}
