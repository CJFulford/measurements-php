<?php

namespace Cjfulford\Measurements;

use Exception;

class LengthImmutable extends AbstractLength
{
    public function add(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length = $length instanceof AbstractLength ? $length : new static($length, $unit);
        return new static($this->value + $length->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length = $length instanceof AbstractLength ? $length : new static($length, $unit);
        return new static($this->value - $length->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $number): static
    {
        return new static($this->value * $number, $this->unit);
    }

    public function mulByLength(AbstractLength|float $length, LengthUnit|int $unit = null): AreaImmutable
    {
        $length = $length instanceof AbstractLength ? $length : new static($length, $unit);
        return new AreaImmutable(
            $this->getValue(LengthUnit::METRE) * $length->getValue(LengthUnit::METRE),
            AreaUnit::SQUARE_METRE
        );
    }

    public function divByNumber(float $number): static
    {
        return new static($this->value / $number, $this->unit);
    }

    /**
     * Round up to the nearest $unit
     * @param int|LengthUnit $unit
     * @return static
     * @throws Exception
     */
    public function ceil(LengthUnit|int $unit): static
    {
        return new static(ceil($this->getValue($unit)), $unit);
    }

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return static
     * @throws Exception
     */
    public function floor(LengthUnit|int $unit): static
    {
        return new static(floor($this->getValue($unit)), $unit);
    }

    /**
     * Round to the nearest $unit
     * @param int|LengthUnit $unit
     * @param int $precision
     * @return static
     * @throws Exception
     */
    public function round(LengthUnit|int $unit, int $precision = 0): static
    {
        return new static(round($this->getValue($unit), $precision), $unit);
    }

    public function modulo(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length = $length instanceof AbstractLength ? $length : new static($length, $unit);
        return new static($this->value % $length->getValue($this->unit), $this->unit);
    }

    public function min(AbstractLength|float $min, LengthUnit|int $unit = null): static
    {
        $min = $min instanceof AbstractLength ? $min : new static($min, $unit);
        return new static(min($this->value, $min->getValue($this->unit)), $this->unit);
    }

    public function max(AbstractLength|float $max, LengthUnit|int $unit = null): static
    {
        $max = $max instanceof AbstractLength ? $max : new static($max, $unit);
        return new static(max($this->value, $max->getValue($this->unit)), $this->unit);
    }
}
