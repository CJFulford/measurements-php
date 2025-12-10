<?php

namespace Cjfulford\Measurements\Area;

use Cjfulford\Measurements\Length\AbstractLength;
use Cjfulford\Measurements\Length\LengthImmutable;
use Cjfulford\Measurements\Unit\AreaUnit;
use Cjfulford\Measurements\Unit\LengthUnit;
use Cjfulford\Measurements\Unit\VolumeUnit;
use Cjfulford\Measurements\Volume\AbstractVolume;
use Cjfulford\Measurements\Volume\VolumeImmutable;

class AreaImmutable extends AbstractArea
{
    public function add(AbstractArea|float $area, AreaUnit|int|null $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        return new self($this->value + $area->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractArea|float $area, AreaUnit|int|null $unit = null): static
    {
        $area = $area instanceof AbstractArea ? $area : new static($area, $unit);
        return new self($this->value - $area->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $number): static
    {
        return new self($this->value * $number, $this->unit);
    }

    public function mulByLength(float|AbstractLength $length, LengthUnit|int|null $unit = null): AbstractVolume
    {
        $length = $length instanceof AbstractLength ? $length : new LengthImmutable($length, $unit);
        return new VolumeImmutable($this->squareMetres() * $length->metres(), VolumeUnit::CUBE_METRE);
    }

    public function divByNumber(float $number): static
    {
        return new self($this->value / $number, $this->unit);
    }

    public function divByLength(AbstractLength|float $length, LengthUnit|int|null $unit = null): LengthImmutable
    {
        $length = $length instanceof AbstractLength ? $length : new LengthImmutable($length, $unit);
        $lengthUnit = $this->unit->correspondingLengthUnit;
        return new LengthImmutable($this->value / $length->getValue($lengthUnit), $lengthUnit);
    }

    public static function zero(): static
    {
        return new self(0, AreaUnit::SQUARE_METRE);
    }
}
