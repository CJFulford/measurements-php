<?php

namespace DANJER\model;

use Cjfulford\Measurements\AbstractLength;
use Cjfulford\Measurements\Area;
use Cjfulford\Measurements\AreaUnit;
use Cjfulford\Measurements\LengthUnit;
use Exception;

class Length extends AbstractLength
{
    public function add(AbstractLength $length): static
    {
        $this->value += $length->getValue($this->unit);
        return $this;
    }

    public function sub(AbstractLength $length): static
    {
        $this->value -= $length->getValue($this->unit);
        return $this;
    }

    public function mulByNumber(float $number): static
    {
        $this->value *= $number;
        return $this;
    }

    public function mulByLength(AbstractLength $length): Area
    {
        return new Area(
            $this->getValue(LengthUnit::METRE) * $length->getValue(LengthUnit::METRE),
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
     * @return self
     * @throws Exception
     */
    public function ceil(LengthUnit|int $unit): static
    {
        $this->value = ceil($this->getValue($unit));
        return $this;
    }

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    public function floor(LengthUnit|int $unit): static
    {
        $this->value = floor($this->getValue($unit));
        return $this;
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
        $this->value = round($this->getValue($unit), $precision);
        return $this;
    }

    public function modulo(AbstractLength $length): static
    {
        $this->value = $this->value % $length->getValue($this->unit);
        return $this;
    }

    public function min(AbstractLength $max): static
    {
        $this->value = min($this->value, $max->getValue($this->unit));
        return $this;
    }

    public function max(AbstractLength $max): static
    {
        $this->value = max($this->value, $max->getValue($this->unit));
        return $this;
    }
}
