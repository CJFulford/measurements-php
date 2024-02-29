<?php

namespace Cjfulford\Measurements;

class AreaImmutable extends AbstractArea
{
    public function add(AbstractArea|float $area, AreaUnit|int $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        return new self($this->value + $area->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractArea|float $area, AreaUnit|int $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        return new self($this->value - $area->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $multiplier): static
    {
        return new self($this->value * $multiplier, $this->unit);
    }

    public function divByNumber(float $divisor): static
    {
        return new self($this->value / $divisor, $this->unit);
    }

    public function divByLength(AbstractLength|float $length, LengthUnit|int $unit = null): LengthImmutable
    {
        $length     = $length instanceof AbstractLength ? $length : new LengthImmutable($length, $unit);
        $lengthUnit = $this->unit->correspondingLengthUnit;
        return new LengthImmutable($this->value / $length->getValue($lengthUnit), $lengthUnit);
    }
}
