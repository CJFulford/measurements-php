<?php

namespace Cjfulford\Measurements;

use DANJER\model\LengthImmutable;

use function Cjfulford\Measurements\Helpers\floatsEqual;

readonly class AreaImmutable
{
    public AreaUnit $unit;
    public bool     $isZero;
    public bool     $isNotZero;
    public float    $inBaseUnits;
    public float    $squareInches;
    public float    $squareFeet;
    public float    $squareMetres;

    public function __construct(public float $value, AreaUnit|int $unit)
    {
        $this->unit         = $unit instanceof AreaUnit ? $unit : new AreaUnit($unit);
        $this->isZero       = floatsEqual($this->value, 0);
        $this->isNotZero    = !$this->isZero;
        $this->inBaseUnits  = $this->getValue(AreaUnit::BASE_UNIT);
        $this->squareInches = $this->getValue(AreaUnit::SQUARE_INCH);
        $this->squareFeet   = $this->getValue(AreaUnit::SQUARE_FOOT);
        $this->squareMetres = $this->getValue(AreaUnit::SQUARE_METRE);
    }

    public function getValue($unit): float
    {
        $unit = $unit instanceof AreaUnit ? $unit : new AreaUnit($unit);

        if ($this->unit === $unit) {
            return $this->value;
        } elseif ($this->unit->isBaseUnit) {
            return $this->value / $unit->baseUnitsPer;
        } elseif ($unit->isBaseUnit) {
            return $this->value * $this->unit->baseUnitsPer;
        }
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    public function add(self $area): self
    {
        return new self($this->value + $area->getValue($this->unit), $this->unit);
    }

    public function sub(self $area): self
    {
        return new self($this->value - $area->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $multiplier): self
    {
        return new self($this->value * $multiplier, $this->unit);
    }

    public function divByNumber(float $divisor): self
    {
        return new self($this->value / $divisor, $this->unit);
    }

    public function divByLength(LengthImmutable $length): LengthImmutable
    {
        $correspondingLengthUnit = $this->unit->correspondingLengthUnit;
        return new LengthImmutable(
            $this->value / $length->getValue($correspondingLengthUnit), $correspondingLengthUnit
        );
    }

    public function divByArea(self $area): float
    {
        return $this->value / $area->getValue($this->unit);
    }

    public function isEqualTo(self $area): bool
    {
        return floatsEqual($this->inBaseUnits, $area->inBaseUnits);
    }

    public function isGreaterThan(self $area, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $area->inBaseUnits <= $this->inBaseUnits
            : $area->inBaseUnits < $this->inBaseUnits;
    }

    public function isLessThan(self $area, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $this->inBaseUnits <= $area->inBaseUnits
            : $this->inBaseUnits < $area->inBaseUnits;
    }

    public function format(AreaUnit|int $unit, int $decimals, Format $format = Format::ACRONYM): string
    {
        return $format->formatArea($this, $unit instanceof AreaUnit ? $unit : new AreaUnit($unit), $decimals);
    }
}
