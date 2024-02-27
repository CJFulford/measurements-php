<?php

namespace Cjfulford\Measurements;

class AreaImmutable extends AbstractArea
{
    public function add(AbstractArea $area): static
    {
        return new self($this->value + $area->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractArea $area): static
    {
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

    public function divByLength(AbstractLength $length): LengthImmutable
    {
        $correspondingLengthUnit = $this->unit->correspondingLengthUnit;
        return new LengthImmutable(
            $this->value / $length->getValue($correspondingLengthUnit), $correspondingLengthUnit
        );
    }
}
