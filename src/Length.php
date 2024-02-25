<?php

namespace DANJER\model;

use Cjfulford\Measurements\Area;
use Cjfulford\Measurements\AreaUnit;
use Cjfulford\Measurements\Format;
use Cjfulford\Measurements\LengthUnit;
use Cjfulford\Measurements\Measurement;
use Exception;

use function Cjfulford\Measurements\Helpers\floatsEqual;

readonly class Length extends Measurement
{
    public LengthUnit $unit;
    protected float   $inBaseUnits;
    public bool       $isZero;
    public bool       $isNotZero;
    public float      $inches;
    public float      $feet;
    public float      $metres;

    /**
     * @param float $value
     * @param int|LengthUnit $unit Should either be an instance of LengthUnit class or one of its constants
     * @throws Exception
     */
    public function __construct(public float $value, LengthUnit|int $unit)
    {
        $this->unit        = $unit instanceof LengthUnit ? $unit : new LengthUnit($unit);
        $this->inBaseUnits = $this->getValue(LengthUnit::BASE_UNIT);
        $this->isZero      = floatsEqual($this->inBaseUnits, 0);
        $this->isNotZero   = !$this->isZero;
        $this->inches      = $this->getValue(LengthUnit::INCH);
        $this->feet        = $this->getValue(LengthUnit::FOOT);
        $this->metres      = $this->getValue(LengthUnit::METRE);
    }

    public function getValue(LengthUnit|int $unit): float
    {
        $unit = $unit instanceof LengthUnit ? $unit : new LengthUnit($unit);

        if ($this->unit === $unit) {
            return $this->value;
        } elseif ($this->unit->isBaseUnit) {
            return $this->value / $unit->baseUnitsPer;
        } elseif ($unit->isBaseUnit) {
            return $this->value * $this->unit->baseUnitsPer;
        }
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    public function add(Length $length): self
    {
        return new Length($this->value + $length->getValue($this->unit), $this->unit);
    }

    public function sub(Length $length): self
    {
        return new Length($this->value - $length->getValue($this->unit), $this->unit);
    }

    public function mulByNumber(float $value): self
    {
        return new Length($this->value * $value, $this->unit);
    }

    public function mulByLength(Length $length): Area
    {
        return new Area(
            $this->getValue(LengthUnit::METRE) * $length->getValue(LengthUnit::METRE),
            AreaUnit::SQUARE_METRE
        );
    }

    public function divByNumber(float $number): self
    {
        return new Length($this->value / $number, $this->unit);
    }

    public function divByLength(Length $length): float
    {
        return $this->value / $length->getValue($this->unit);
    }

    /**
     * Round up to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    public function ceil(LengthUnit|int $unit): self
    {
        return new Length(ceil($this->getValue($unit)), $unit);
    }

    /**
     * Round down to the nearest $unit
     * @param int|LengthUnit $unit
     * @return self
     * @throws Exception
     */
    public function floor(LengthUnit|int $unit): self
    {
        return new Length(floor($this->getValue($unit)), $unit);
    }

    /**
     * Round to the nearest $unit
     * @param int|LengthUnit $unit
     * @param int $precision
     * @return self
     * @throws Exception
     */
    public function round(LengthUnit|int $unit, int $precision = 0): self
    {
        return new Length(round($this->getValue($unit), $precision), $unit);
    }

    public function modulo(Length $length): self
    {
        return new Length($this->inBaseUnits % $length->inBaseUnits, LengthUnit::BASE_UNIT);
    }

    public function min(Length $max): self
    {
        return new Length(min($this->value, $max->getValue($this->unit)), $this->unit);
    }

    public function max(Length $max): self
    {
        return new Length(max($this->value, $max->getValue($this->unit)), $this->unit);
    }

    public function clamp(Length $min, Length $max): self
    {
        return $this->max($min)->min($max);
    }

    public function isEqualTo(Length $length): bool
    {
        return floatsEqual($this->inBaseUnits, $length->inBaseUnits);
    }

    public function isLessThan(Length $length, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $this->inBaseUnits <= $length->inBaseUnits
            : $this->inBaseUnits < $length->inBaseUnits;
    }

    public function isGreaterThan(Length $length, bool $orEqualTo): bool
    {
        return $orEqualTo
            ? $length->inBaseUnits <= $this->inBaseUnits
            : $length->inBaseUnits < $this->inBaseUnits;
    }

    public function format(LengthUnit|int $unit, int $decimals = 0, Format $format = Format::SYMBOL): string
    {
        return $format->formatLength($this, $unit, $decimals);
    }
}
