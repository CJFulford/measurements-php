<?php

namespace Cjfulford\Measurements\Length;

use Cjfulford\Measurements\AbstractMeasurement;
use Cjfulford\Measurements\Area\AbstractArea;
use Cjfulford\Measurements\Format;
use Cjfulford\Measurements\Unit\LengthUnit;
use Exception;
use function Cjfulford\Measurements\Helpers\floatsEqual;
use function Cjfulford\Measurements\Helpers\floatsGreaterThan;
use function Cjfulford\Measurements\Helpers\floatsLessThan;
use const Cjfulford\Measurements\DEFAULT_PRECISION;

require_once __DIR__ . '/../Helpers.php';

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

    abstract public function add(self|float $length, LengthUnit|int|null $unit = null): static;

    abstract public function sub(self|float $length, LengthUnit|int|null $unit = null): static;

    abstract public function mulByLength(self|float $length, LengthUnit|int|null $unit = null): AbstractArea;

    final public function divByLength(self|float $length, LengthUnit|int|null $unit = null): float
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

    abstract public function modulo(self|float $length, LengthUnit|int|null $unit = null): static;

    abstract public function min(self|float $min, LengthUnit|int|null $unit = null): static;

    abstract public function max(self|float $max, LengthUnit|int|null $unit = null): static;

    final public function clamp(
        self|float          $min,
        self|float          $max,
        LengthUnit|int|null $minUnit = null,
        LengthUnit|int|null $maxUnit = null
    ): static
    {
        return $this->max($min, $minUnit)->min($max, $maxUnit);
    }

    final public function isEqualTo(
        self|float          $length,
        LengthUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        $length = $length instanceof self ? $length : new static($length, $unit);
        return floatsEqual($this->value, $length->getValue($this->unit), $precision);
    }

    final public function isNotEqualTo(
        self|float          $length,
        LengthUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return !$this->isEqualTo($length, $unit, $precision);
    }

    final public function isLessThan(self|float $length, LengthUnit|int|null $unit = null): bool
    {
        return $length instanceof self
            ? floatsLessThan($this->value, $length->getValue($this->unit))
            : $this->isLessThan(new static($length, $unit));
    }

    final public function isLessThanOrEqualTo(
        self|float          $length,
        LengthUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return $length instanceof self
            ? $this->isLessThan($length) || $this->isEqualTo($length, precision: $precision)
            : $this->isLessThanOrEqualTo(new static($length, $unit));
    }

    final public function isGreaterThan(self|float $length, LengthUnit|int|null $unit = null): bool
    {
        return $length instanceof self
            ? floatsGreaterThan($this->value, $length->getValue($this->unit))
            : $this->isGreaterThan(new static($length, $unit));
    }

    final public function isGreaterThanOrEqualTo(
        self|float          $length,
        LengthUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return $length instanceof self
            ? $this->isGreaterThan($length) || $this->isEqualTo($length, precision: $precision)
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

    /**
     * @param array<LengthUnit|int> $units
     * @param int $decimals
     * @param Format $format
     * @param string $separator
     * @return string
     * @throws Exception
     */
    final public function multiFormat(
        array  $units,
        int    $decimals,
        Format $format = Format::SYMBOL,
        string $separator = ','
    ): string
    {
        // Sort units so that the largest unit is first
        usort($units, function (LengthUnit|int $a, LengthUnit|int $b) {
            $a = $a instanceof LengthUnit ? $a : LengthUnit::getById($a);
            $b = $b instanceof LengthUnit ? $b : LengthUnit::getById($b);
            return $b->baseUnitsPer <=> $a->baseUnitsPer;
        });

        $result = [];
        $remaining = new LengthImmutable($this->value, $this->unit);
        foreach ($units as $i => $unit) {
            $isLastUnit = $i === count($units) - 1;

            if ($isLastUnit) {
                $portion = $remaining;
                $portionDecimals = $decimals;
            } else {
                $portion = new LengthImmutable(floor($remaining->getValue($unit)), $unit);
                $portionDecimals = 0;
                $remaining = $remaining->sub($portion);

                if ($portion->isZero()) {
                    continue;
                }
            }

            $result[] = $portion->format($unit, $portionDecimals, $format);
        }

        return implode($separator, $result);
    }

    final public function toImmutable(): LengthImmutable
    {
        return new LengthImmutable($this->value, $this->unit);
    }

    final public function toMutable(): Length
    {
        return new Length($this->value, $this->unit);
    }

    final public function getUnit(): LengthUnit
    {
        return $this->unit;
    }
}
