<?php

namespace Cjfulford\Measurements;

use Exception;

class LengthImmutable extends AbstractLength
{
    public function add(AbstractLength $length): static
    {
        return new self($this->value + $length->getValue($this->unit), $this->unit);
    }

    public function sub(AbstractLength $length): static
    {
        return new self($this->value - $length->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $number): static
    {
        return new self($this->value * $number, $this->unit);
    }

    public function mulByLength(AbstractLength $length): AreaImmutable
    {
        return new AreaImmutable(
            $this->getValue(LengthUnit::METRE) * $length->getValue(LengthUnit::METRE),
            AreaUnit::SQUARE_METRE
        );
    }

    public function divByNumber(float $number): static
    {
        return new self($this->value / $number, $this->unit);
    }

    /**
     * Round up to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    public function ceil(LengthUnit|int $unit): static
    {
        return new self(ceil($this->getValue($unit)), $unit);
    }

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    public function floor(LengthUnit|int $unit): static
    {
        return new self(floor($this->getValue($unit)), $unit);
    }

    /**
     * Round to the nearest $unit
     * @param int|LengthUnit $unit
     * @param int $precision
     * @return self
     * @throws Exception
     */
    public function round(LengthUnit|int $unit, int $precision = 0): static
    {
        return new self(round($this->getValue($unit), $precision), $unit);
    }

    public function modulo(AbstractLength $length): static
    {
        return new self($this->value % $length->getValue($this->unit), $this->unit);
    }

    public function min(AbstractLength $max): static
    {
        return new self(min($this->value, $max->getValue($this->unit)), $this->unit);
    }

    public function max(AbstractLength $max): static
    {
        return new self(max($this->value, $max->getValue($this->unit)), $this->unit);
    }
}
