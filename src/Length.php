<?php

namespace Cjfulford\Measurements;

use Exception;

class Length extends AbstractLength
{
    public function add(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length      = $length instanceof AbstractLength ? $length : new static($length, $unit);
        $this->value += $length->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length      = $length instanceof AbstractLength ? $length : new static($length, $unit);
        $this->value -= $length->getValue($this->unit);
        return $this;
    }

    public function mulByNumber(float $number): static
    {
        $this->value *= $number;
        return $this;
    }

    public function mulByLength(AbstractLength|float $length, LengthUnit|int $unit = null): Area
    {
        $length = $length instanceof AbstractLength ? $length : new static($length, $unit);
        return new Area(
            $this->metres() * $length->metres(),
            AreaUnit::SQUARE_METRE
        );
    }

    public function divByNumber(float $number): static
    {
        $this->value /= $number;
        return $this;
    }

    /**
     * Round up to the nearest $unit
     * @param int|LengthUnit $unit
     * @return static
     * @throws Exception
     */
    public function ceil(LengthUnit|int $unit): static
    {
        $this->value = ceil($this->getValue($unit));
        $this->unit  = $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit);
        return $this;
    }

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return static
     * @throws Exception
     */
    public function floor(LengthUnit|int $unit): static
    {
        $this->value = floor($this->getValue($unit));
        $this->unit  = $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit);
        return $this;
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
        $this->value = round($this->getValue($unit), $precision);
        $this->unit  = $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit);
        return $this;
    }

    public function modulo(AbstractLength|float $length, LengthUnit|int $unit = null): static
    {
        $length      = $length instanceof AbstractLength ? $length : new static($length, $unit);
        $this->value = $this->value % $length->getValue($this->unit);
        return $this;
    }

    public function min(AbstractLength|float $min, LengthUnit|int $unit = null): static
    {
        $min         = $min instanceof AbstractLength ? $min : new static($min, $unit);
        $this->value = min($this->value, $min->getValue($this->unit));
        return $this;
    }

    public function max(AbstractLength|float $max, LengthUnit|int $unit = null): static
    {
        $max         = $max instanceof AbstractLength ? $max : new static($max, $unit);
        $this->value = max($this->value, $max->getValue($this->unit));
        return $this;
    }

    public static function zero(): static
    {
        return new self(0, LengthUnit::METRE);
    }
}
