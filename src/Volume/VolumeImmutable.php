<?php

namespace Cjfulford\Measurements\Volume;

use Cjfulford\Measurements\Unit\VolumeUnit;
use Exception;

class VolumeImmutable extends AbstractVolume
{
    public function add(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        return new static($this->value + $volume->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        return new static($this->value - $volume->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $number): static
    {
        return new static($this->value * $number, $this->unit);
    }

    public function divByNumber(float $number): static
    {
        return new static($this->value / $number, $this->unit);
    }

    /**
     * Round up to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return static
     * @throws Exception
     */
    public function ceil(VolumeUnit|int $unit): static
    {
        return new static(ceil($this->getValue($unit)), $unit);
    }

    /**
     * Round down to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return static
     * @throws Exception
     */
    public function floor(VolumeUnit|int $unit): static
    {
        return new static(floor($this->getValue($unit)), $unit);
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
        return new static(round($this->getValue($unit), $precision), $unit);
    }

    public function modulo(AbstractVolume|float $volume, VolumeUnit|int|null $unit = null): static
    {
        $volume = $volume instanceof AbstractVolume ? $volume : new static($volume, $unit);
        return new static($this->value % $volume->getValue($this->unit), $this->unit);
    }

    public function min(AbstractVolume|float $min, VolumeUnit|int|null $unit = null): static
    {
        $min = $min instanceof AbstractVolume ? $min : new static($min, $unit);
        return new static(min($this->value, $min->getValue($this->unit)), $this->unit);
    }

    public function max(AbstractVolume|float $max, VolumeUnit|int|null $unit = null): static
    {
        $max = $max instanceof AbstractVolume ? $max : new static($max, $unit);
        return new static(max($this->value, $max->getValue($this->unit)), $this->unit);
    }

    public static function zero(): static
    {
        return new static(0, VolumeUnit::CUBE_METRE);
    }
}
