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

    public function mulByNumber(float $number): static
    {
        return new self($this->value * $number, $this->unit);
    }

    public function divByNumber(float $number): static
    {
        return new self($this->value / $number, $this->unit);
    }

    public function divByLength(AbstractLength|float $length, LengthUnit|int $unit = null): LengthImmutable
    {
        $length     = $length instanceof AbstractLength ? $length : new LengthImmutable($length, $unit);
        $lengthUnit = $this->unit->correspondingLengthUnit;
        return new LengthImmutable($this->value / $length->getValue($lengthUnit), $lengthUnit);
    }

    public function toImmutable(): AreaImmutable
    {
        return $this;
    }

    public function toMutable(): Area
    {
        return new Area($this->value, $this->unit);
    }

    public static function zero(): static
    {
        return new self(0, AreaUnit::SQUARE_METRE);
    }
}
