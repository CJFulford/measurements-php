<?php

namespace Cjfulford\Measurements;

use Exception;

class Volume extends AbstractVolume
{
    public function add(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        $this->value += $volume->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        $this->value -= $volume->getValue($this->unit);
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

    public function divByLength(float|AbstractLength $length, LengthUnit|int|null $unit = null): AbstractArea
    {
        $length = $length instanceof AbstractLength ? $length : new Length($length, $unit);
        return new Area($this->cubeMetres() / $length->metres(), AreaUnit::SQUARE_METRE);
    }

    public function divByArea(float|AbstractArea $area, AreaUnit|int|null $unit = null): AbstractLength
    {
        $area = $area instanceof AbstractArea ? $area : new Area($area, $unit);
        return new Length($this->cubeMetres() / $area->squareMetres(), LengthUnit::METRE);
    }

    /**
     * Round up to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return static
     * @throws Exception
     */
    public function ceil(VolumeUnit|int $unit): static
    {
        $this->value = ceil($this->getValue($unit));
        $this->unit = $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit);
        return $this;
    }

    /**
     * Round down to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return static
     * @throws Exception
     */
    public function floor(VolumeUnit|int $unit): static
    {
        $this->value = floor($this->getValue($unit));
        $this->unit = $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit);
        return $this;
    }

    /**
     * Round to the nearest $unit
     * @param int|VolumeUnit $unit
     * @param int $precision
     * @return static
     * @throws Exception
     */
    public function round(VolumeUnit|int $unit, int $precision = 0): static
    {
        $this->value = round($this->getValue($unit), $precision);
        $this->unit = $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit);
        return $this;
    }

    public function modulo(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        $this->value = $this->value % $volume->getValue($this->unit);
        return $this;
    }

    public function min(AbstractVolume|float $min, VolumeUnit|int|null $unit = null): static
    {
        $min = $min instanceof AbstractVolume ? $min : new static($min, $unit);
        $this->value = min($this->value, $min->getValue($this->unit));
        return $this;
    }

    public function max(AbstractVolume|float $max, VolumeUnit|int|null $unit = null): static
    {
        $max = $max instanceof AbstractVolume ? $max : new static($max, $unit);
        $this->value = max($this->value, $max->getValue($this->unit));
        return $this;
    }

    public static function zero(): static
    {
        return new self(0, VolumeUnit::CUBE_METRE);
    }
}
