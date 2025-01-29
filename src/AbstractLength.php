<?php

namespace Cjfulford\Measurements;

use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

require_once 'Helpers.php';

abstract class AbstractLength extends AbstractMeasurement
{
    protected LengthUnit $unit;

    /**
     * @param float $value
     * @param int|LengthUnit $unit Should either be an instance of LengthUnit class or one of its constants
     * @throws Exception
     */
    final public function __construct(float $value, LengthUnit|int $unit)
    {
        parent::__construct($value);
        $this->unit = $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit);
    }

    final public function getValue(LengthUnit|int $unit): float
    {
        $unit = $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit);
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    final public function kilometres(): float
    {
        return $this->getValue(LengthUnit::KILOMETRE);
    }

    final public function metres(): float
    {
        return $this->getValue(LengthUnit::METRE);
    }

    final public function centimetres(): float
    {
        return $this->getValue(LengthUnit::CENTIMETRE);
    }

    final public function millimetres(): float
    {
        return $this->getValue(LengthUnit::MILLIMETRE);
    }

    final public function inches(): float
    {
        return $this->getValue(LengthUnit::INCH);
    }

    final public function feet(): float
    {
        return $this->getValue(LengthUnit::FOOT);
    }

    final public function yards(): float
    {
        return $this->getValue(LengthUnit::YARD);
    }

    final public function miles(): float
    {
        return $this->getValue(LengthUnit::MILE);
    }

    abstract public function add(self|float $length, LengthUnit|int $unit = null): static;

    abstract public function sub(self|float $length, LengthUnit|int $unit = null): static;

    abstract public function mulByLength(self|float $length, LengthUnit|int $unit = null): AbstractArea;

    final public function divByLength(self|float $length, LengthUnit|int $unit = null): float
    {
        return $length instanceof self
            ? $this->value / $length->getValue($this->unit)
            : $this->divByLength(new static($length, $unit));
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

    abstract public function modulo(self|float $length, LengthUnit|int $unit = null): static;

    abstract public function min(self|float $min, LengthUnit|int $unit = null): static;

    abstract public function max(self|float $max, LengthUnit|int $unit = null): static;

    final public function clamp(
        self|float     $min,
        self|float     $max,
        LengthUnit|int $minUnit = null,
        LengthUnit|int $maxUnit = null
    ): static {
        return $this->max($min, $minUnit)->min($max, $maxUnit);
    }

    final public function isEqualTo(self|float $length, LengthUnit|int $unit = null): bool
    {
        return $length instanceof self
            ? floatsEqual($this->value, $length->getValue($this->unit))
            : $this->isEqualTo(new static($length, $unit));
    }

    final public function isLessThan(self|float $length, LengthUnit|int $unit = null): bool
    {
        return $length instanceof self
            ? $this->value < $length->getValue($this->unit)
            : $this->isLessThan(new static($length, $unit));
    }

    final public function isLessThanOrEqualTo(self|float $length, LengthUnit|int $unit = null): bool
    {
        return $length instanceof self
            ? $this->isLessThan($length) || $this->isEqualTo($length)
            : $this->isLessThanOrEqualTo(new static($length, $unit));
    }

    final public function isGreaterThan(self|float $length, LengthUnit|int $unit = null): bool
    {
        return $length instanceof self
            ? $this->value > $length->getValue($this->unit)
            : $this->isGreaterThan(new static($length, $unit));
    }

    final public function isGreaterThanOrEqualTo(self|float $length, LengthUnit|int $unit = null): bool
    {
        return $length instanceof self
            ? $this->isGreaterThan($length) || $this->isEqualTo($length)
            : $this->isGreaterThanOrEqualTo(new static($length, $unit));
    }

    final public function format(LengthUnit|int $unit, int $decimals = 0, Format $format = Format::SYMBOL): string
    {
        return $format->formatLength(
            $this,
            $unit instanceof LengthUnit ? $unit : LengthUnit::getById($unit),
            $decimals
        );
    }

    final public function toImmutable(): LengthImmutable
    {
        return new LengthImmutable($this->value, $this->unit);
    }

    final public function toMutable(): Length
    {
        return new Length($this->value, $this->unit);
    }
}
