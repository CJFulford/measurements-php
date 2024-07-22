<?php

namespace Cjfulford\Measurements;

class Area extends AbstractArea implements Mutable
{
    public function add(AbstractArea|float $area, AreaUnit|int $unit = null): static
    {
        $area        = $area instanceof AbstractArea ? $area : new static($area, $unit);
        $this->value += $area->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractArea|float $area, AreaUnit|int $unit = null): static
    {
        $area        = $area instanceof AbstractArea ? $area : new static($area, $unit);
        $this->value -= $area->getValue($this->unit);
        return $this;
    }

    public function mulByNumber(float $multiplier): static
    {
        $this->value *= $multiplier;
        return $this;
    }

    public function divByNumber(float $divisor): static
    {
        $this->value /= $divisor;
        return $this;
    }

    public function divByLength(AbstractLength|float $length, LengthUnit|int $unit = null): Length
    {
        $length     = $length instanceof AbstractLength ? $length : new Length($length, $unit);
        $lengthUnit = $this->unit->correspondingLengthUnit;
        return new Length($this->value / $length->getValue($lengthUnit), $lengthUnit);
    }

    public function toImmutable(): AreaImmutable
    {
        return new AreaImmutable($this->value, $this->unit);
    }
}
