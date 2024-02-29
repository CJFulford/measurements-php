<?php

namespace Cjfulford\Measurements;


use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

require_once 'Helpers.php';

abstract class AbstractArea
{
    protected float    $value;
    protected AreaUnit $unit;

    /**
     * @param float $value
     * @param int|AreaUnit $unit Should either be an instance of AreaUnit class or one of its constants
     * @throws Exception
     */
    final public function __construct(float $value, AreaUnit|int $unit)
    {
        $this->value = $value;
        $this->unit  = $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit);
    }

    final public function getValue(AreaUnit|int $unit): float
    {
        $unit = $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit);
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    abstract public function add(self|float $area, AreaUnit|int $unit = null): static;

    abstract public function sub(self|float $area, AreaUnit|int $unit = null): static;

    abstract public function mulByNumber(float $multiplier): static;

    abstract public function divByNumber(float $divisor): static;

    abstract public function divByLength(AbstractLength|float $length, LengthUnit|int $unit = null): AbstractLength;

    final public function divByArea(self|float $area, AreaUnit|int $unit = null): float
    {
        $area = $area instanceof self ? $area : new static($area, $unit);
        return $this->value / $area->getValue($this->unit);
    }

    final public function isEqualTo(self|float $area, AreaUnit|int $unit = null): bool
    {
        $area = $area instanceof self ? $area : new static($area, $unit);
        return floatsEqual($this->value, $area->getValue($this->unit));
    }

    final public function isLessThan(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value < $area->getValue($this->unit)
            : $this->isLessThan(new static($area, $unit));
    }

    final public function isLessThanOrEqualTo(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value <= $area->getValue($this->unit)
            : $this->isLessThanOrEqualTo(new static($area, $unit));
    }

    final public function isGreaterThan(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value > $area->getValue($this->unit)
            : $this->isGreaterThan(new static($area, $unit));
    }

    final public function isGreaterThanOrEqualTo(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value >= $area->getValue($this->unit)
            : $this->isGreaterThanOrEqualTo(new static($area, $unit));
    }

    final public function format(AreaUnit|int $unit, int $decimals, Format $format = Format::ACRONYM): string
    {
        return $format->formatArea($this, $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit), $decimals);
    }
}
