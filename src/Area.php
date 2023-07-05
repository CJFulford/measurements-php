<?php

namespace Cjfulford\Measurements;

use Exception;

class Area extends Measurement
{

    public function __construct(float $value, AreaUnit|int $unit)
    {
        parent::__construct(
            value    : $value,
            unit     : $unit,
            unitClass: AreaUnit::class
        );
    }

    public function getUnit(): AreaUnit
    {
        return new AreaUnit($this->unitId);
    }

    /**
     * An area divided by a length returns a new length as the units cancel out.
     * This instance is not modified
     *
     * @param Length|float $length
     * @param LengthUnit|int|null $unit
     * @return Length
     * @throws Exception
     */
    public function divByLength(Length|float $length, LengthUnit|int|null $unit = null): Length
    {
        if ($length instanceof Length) {
            $area   = $this->value;
            $length = $length->getValue($this->getUnit());
            return new Length($area / $length, Unit::METRE);
        }

        // recurse on this function now that the argument is a Length
        return $this->divByLength(new Length($length, $unit));
    }

    /**
     * An area divided by an area returns a number as the units cancel out.
     * This instance is not modified
     *
     * @param Area|float $area
     * @param AreaUnit|int|null $unit
     * @return float
     * @throws Exception
     */
    public function divByArea(Area|float $area, AreaUnit|int|null $unit = null): float
    {
        return $area instanceof Area
            ? $this->value / $area->getValue($this->getUnit())
            : $this->divByArea(new Area($area, $unit));
    }
}
