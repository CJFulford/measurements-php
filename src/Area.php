<?php

namespace Cjfulford\Measurements;

class Area extends AbstractArea
{
    public function add(AbstractArea $area): static
    {
        $this->value += $area->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractArea $area): static
    {
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

    public function divByLength(AbstractLength $length): Length
    {
        $correspondingLengthUnit = $this->unit->correspondingLengthUnit;
        return new Length(
            $this->value / $length->getValue($correspondingLengthUnit), $correspondingLengthUnit
        );
    }
}
