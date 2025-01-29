<?php

namespace Cjfulford\Measurements;


use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

require_once 'Helpers.php';

abstract class AbstractArea extends AbstractMeasurement
{
    protected AreaUnit $unit;

    /**
     * @param float $value
     * @param int|AreaUnit $unit Should either be an instance of AreaUnit class or one of its constants
     * @throws Exception
     */
    final public function __construct(float $value, AreaUnit|int $unit)
    {
        parent::__construct($value);
        $this->unit = $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit);
    }

    final public function getValue(AreaUnit|int $unit): float
    {
        $unit = $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit);
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    final public function squareKilometres(): float
    {
        return $this->getValue(AreaUnit::SQUARE_KILOMETRE);
    }

    final public function squareMetres(): float
    {
        return $this->getValue(AreaUnit::SQUARE_METRE);
    }

    final public function squareCentimetres(): float
    {
        return $this->getValue(AreaUnit::SQUARE_CENTIMETRE);
    }

    final public function squareMillimetres(): float
    {
        return $this->getValue(AreaUnit::SQUARE_MILLIMETRE);
    }

    final public function squareInches(): float
    {
        return $this->getValue(AreaUnit::SQUARE_INCH);
    }

    final public function squareFeet(): float
    {
        return $this->getValue(AreaUnit::SQUARE_FOOT);
    }

    final public function squareYards(): float
    {
        return $this->getValue(AreaUnit::SQUARE_YARD);
    }

    final public function squareMiles(): float
    {
        return $this->getValue(AreaUnit::SQUARE_MILE);
    }

    abstract public function add(self|float $area, AreaUnit|int $unit = null): static;

    abstract public function sub(self|float $area, AreaUnit|int $unit = null): static;

    abstract public function divByLength(AbstractLength|float $length, LengthUnit|int $unit = null): AbstractLength;

    final public function divByArea(self|float $area, AreaUnit|int $unit = null): float
    {
        $area = $area instanceof self ? $area : new static($area, $unit);
        return $this->value / $area->getValue($this->unit);
    }

    final public function isEqualTo(
        self|float $area,
        AreaUnit|int $unit = null,
        int $precision = DEFAULT_PRECISION
    ): bool {
        $area = $area instanceof self ? $area : new static($area, $unit);
        return floatsEqual($this->value, $area->getValue($this->unit), $precision);
    }

    final public function isLessThan(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value < $area->getValue($this->unit)
            : $this->isLessThan(new static($area, $unit));
    }

    final public function isLessThanOrEqualTo(
        self|float   $area,
        AreaUnit|int $unit = null,
        int          $precision = DEFAULT_PRECISION
    ): bool {
        return $area instanceof self
            ? $this->isLessThan($area) || $this->isEqualTo($area, precision: $precision)
            : $this->isLessThanOrEqualTo(new static($area, $unit));
    }

    final public function isGreaterThan(self|float $area, AreaUnit|int $unit = null): bool
    {
        return $area instanceof self
            ? $this->value > $area->getValue($this->unit)
            : $this->isGreaterThan(new static($area, $unit));
    }

    final public function isGreaterThanOrEqualTo(
        self|float   $area,
        AreaUnit|int $unit = null,
        int          $precision = DEFAULT_PRECISION
    ): bool {
        return $area instanceof self
            ? $this->isGreaterThan($area) || $this->isEqualTo($area, precision: $precision)
            : $this->isGreaterThanOrEqualTo(new static($area, $unit));
    }

    final public function format(AreaUnit|int $unit, int $decimals, Format $format = Format::ACRONYM): string
    {
        return $format->formatArea($this, $unit instanceof AreaUnit ? $unit : AreaUnit::getById($unit), $decimals);
    }

    /**
     * @param array<AreaUnit|int> $units
     * @param int $decimals
     * @param Format $format
     * @param string $separator
     * @return string
     * @throws Exception
     */
    final public function multiFormat(
        array  $units,
        int    $decimals,
        Format $format = Format::ACRONYM,
        string $separator = ','
    ): string {
        // Sort units so that the largest unit is first
        usort($units, function (AreaUnit|int $a, AreaUnit|int $b) {
            $a = $a instanceof AreaUnit ? $a : AreaUnit::getById($a);
            $b = $b instanceof AreaUnit ? $b : AreaUnit::getById($b);
            return $b->baseUnitsPer <=> $a->baseUnitsPer;
        });

        $result    = [];
        $remaining = new AreaImmutable($this->value, $this->unit);
        foreach ($units as $i => $unit) {
            $isLastUnit = $i === count($units) - 1;

            if ($isLastUnit) {
                $portion         = $remaining;
                $portionDecimals = $decimals;
            } else {
                $portion         = new AreaImmutable(floor($remaining->getValue($unit)), $unit);
                $portionDecimals = 0;
                $remaining       = $remaining->sub($portion);

                if ($portion->isZero()) {
                    continue;
                }
            }

            $result[] = $portion->format($unit, $portionDecimals, $format);
        }

        return implode($separator, $result);
    }

    final public function toImmutable(): AreaImmutable
    {
        return new AreaImmutable($this->value, $this->unit);
    }

    final public function toMutable(): Area
    {
        return new Area($this->value, $this->unit);
    }
}
