<?php

namespace Cjfulford\Measurements;

use Exception;

class Length extends Measurement
{

    public function __construct(float $value, LengthUnit|int $unit)
    {
        parent::__construct(
            value    : $value,
            unit     : $unit,
            unitClass: LengthUnit::class
        );
    }

    public function getUnit(): LengthUnit
    {
        return new LengthUnit($this->unitId);
    }

    /**
     * A length divided by a length causes the units to cancel out and therefore this returns a number.
     * This instance is not modified
     *
     * @param Length|float $length
     * @param LengthUnit|int|null $unit
     * @return float
     * @throws Exception
     */
    public function divByLength(Length|float $length, LengthUnit|int|null $unit = null): float
    {
        return $length instanceof Length
            ? $this->value / $length->getValue($this->getUnit())
            : $this->divByLength(new self($length, $unit));
    }
}
