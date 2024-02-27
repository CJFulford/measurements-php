<?php

namespace Cjfulford\Measurements;


use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

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

    abstract public function add(self $area): static;

    abstract public function sub(self $area): static;

    abstract public function mulByNumber(float $multiplier): static;

    abstract public function divByNumber(float $divisor): static;

    abstract public function divByLength(AbstractLength $length): AbstractLength;

    final public function divByArea(self $area): float
    {
        return $this->value / $area->getValue($this->unit);
    }

    final public function isEqualTo(self $area): bool
    {
        return floatsEqual($this->value, $area->getValue($this->unit));
    }

    final public function isGreaterThan(self $area, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $area->getValue($this->unit) <= $this->value
            : $area->getValue($this->unit) < $this->value;
    }

    final public function isLessThan(self $area, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $this->value <= $area->getValue($this->unit)
            : $this->value < $area->getValue($this->unit);
    }

    final public function format(AreaUnit|int $unit, int $decimals, Format $format = Format::ACRONYM): string
    {
        return $format->formatArea($this, $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit), $decimals);
    }
}
