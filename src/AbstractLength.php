<?php

namespace Cjfulford\Measurements;

use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

abstract class AbstractLength
{
    protected float      $value;
    protected LengthUnit $unit;

    /**
     * @param float $value
     * @param int|LengthUnit $unit Should either be an instance of LengthUnit class or one of its constants
     * @throws Exception
     */
    final public function __construct(float $value, LengthUnit|int $unit)
    {
        $this->value = $value;
        $this->unit  = $unit instanceof LengthUnit ? $unit : new LengthUnit($unit);
    }

    final public function getValue(LengthUnit|int $unit): float
    {
        $unit = $unit instanceof LengthUnit ? $unit : new LengthUnit($unit);
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    abstract public function add(self $length): static;

    abstract public function sub(self $length): static;

    abstract public function mulByNumber(float $number): static;

    abstract public function mulByLength(self $length): AbstractArea;

    abstract public function divByNumber(float $number): static;

    final public function divByLength(self $length): float
    {
        return $this->value / $length->getValue($this->unit);
    }

    /**
     * Round up to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    abstract public function ceil(LengthUnit|int $unit): static;

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    abstract public function floor(LengthUnit|int $unit): static;

    /**
     * Round to the nearest $unit
     * @param int|LengthUnit $unit
     * @param int $precision
     * @return self
     * @throws Exception
     */
    abstract public function round(LengthUnit|int $unit, int $precision = 0): static;

    abstract public function modulo(self $length): static;

    abstract public function min(self $max): static;

    abstract public function max(self $max): static;

    final public function clamp(self $min, self $max): static
    {
        return $this->max($min)->min($max);
    }

    final public function isEqualTo(self $length): bool
    {
        return floatsEqual($this->value, $length->getValue($this->unit));
    }

    final public function isLessThan(self $length, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $this->value <= $length->getValue($this->unit)
            : $this->value < $length->getValue($this->unit);
    }

    final public function isGreaterThan(self $length, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $length->getValue($this->unit) <= $this->value
            : $length->getValue($this->unit) < $this->value;
    }

    final public function format(LengthUnit|int $unit, int $decimals = 0, Format $format = Format::SYMBOL): string
    {
        return $format->formatLength($this, $unit, $decimals);
    }
}
