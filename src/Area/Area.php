<?php

namespace Cjfulford\Measurements\Area;

use Cjfulford\Measurements\Length\AbstractLength;
use Cjfulford\Measurements\Length\Length;
use Cjfulford\Measurements\Unit\AreaUnit;
use Cjfulford\Measurements\Unit\LengthUnit;

class Area extends AbstractArea
{
    public function add(AbstractArea|float $area, AreaUnit|int|null $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        $this->value += $area->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractArea|float $area, AreaUnit|int|null $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        $this->value -= $area->getValue($this->unit);
        return $this;
    }

    public function mulByNumber(float $number): static
    {
        $this->value *= $number;
        return $this;
    }

    public function divByNumber(float $number): static
    {
        $this->value /= $number;
        return $this;
    }

    public function divByLength(AbstractLength|float $length, LengthUnit|int|null $unit = null): Length
    {
        $length = $length instanceof AbstractLength ? $length : new Length($length, $unit);
        $lengthUnit = $this->unit->correspondingLengthUnit;
        return new Length($this->value / $length->getValue($lengthUnit), $lengthUnit);
    }


    public static function zero(): static
    {
        return new self(0, AreaUnit::SQUARE_METRE);
    }
}
