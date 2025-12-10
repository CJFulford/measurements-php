<?php

namespace Cjfulford\Measurements\Volume;

use Cjfulford\Measurements\AbstractMeasurement;
use Cjfulford\Measurements\Format;
use Cjfulford\Measurements\Unit\VolumeUnit;
use Exception;
use function Cjfulford\Measurements\Helpers\floatsEqual;
use function Cjfulford\Measurements\Helpers\floatsGreaterThan;
use function Cjfulford\Measurements\Helpers\floatsLessThan;
use const Cjfulford\Measurements\DEFAULT_PRECISION;

require_once __DIR__ . '/../Helpers.php';

abstract class AbstractVolume extends AbstractMeasurement
{
    protected VolumeUnit $unit;

    /**
     * @param float $value
     * @param int|VolumeUnit $unit Should either be an instance of VolumeUnit class or one of its constants
     * @throws Exception
     */
    final public function __construct(float $value, VolumeUnit|int $unit)
    {
        parent::__construct($value);
        $this->unit = $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit);
    }

    final public function getValue(VolumeUnit|int $unit): float
    {
        $unit = $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit);
        return $this->value * $this->unit->baseUnitsPer / $unit->baseUnitsPer;
    }

    final public function kilometres(): float
    {
        return $this->getValue(VolumeUnit::CUBE_KILOMETRE);
    }

    final public function metres(): float
    {
        return $this->getValue(VolumeUnit::CUBE_METRE);
    }

    final public function centimetres(): float
    {
        return $this->getValue(VolumeUnit::CUBE_CENTIMETRE);
    }

    final public function millimetres(): float
    {
        return $this->getValue(VolumeUnit::CUBE_MILLIMETRE);
    }

    final public function inches(): float
    {
        return $this->getValue(VolumeUnit::CUBE_INCH);
    }

    final public function feet(): float
    {
        return $this->getValue(VolumeUnit::CUBE_FOOT);
    }

    final public function yards(): float
    {
        return $this->getValue(VolumeUnit::CUBE_YARD);
    }

    final public function miles(): float
    {
        return $this->getValue(VolumeUnit::CUBE_MILE);
    }

    abstract public function add(self|float $volume, VolumeUnit|int|null $unit = null): static;

    abstract public function sub(self|float $volume, VolumeUnit|int|null $unit = null): static;

    final public function divByVolume(self|float $volume, VolumeUnit|int|null $unit = null): float
    {
        return $volume instanceof self
            ? $this->value / $volume->getValue($this->unit)
            : $this->divByVolume(new static($volume, $unit));
    }

    /**
     * Round up to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return self
     * @throws Exception
     */
    abstract public function ceil(VolumeUnit|int $unit): static;

    /**
     * Round down to the nearest $unit
     * @param int|VolumeUnit $unit
     * @return self
     * @throws Exception
     */
    abstract public function floor(VolumeUnit|int $unit): static;

    /**
     * Round to the nearest $unit
     * @param int|VolumeUnit $unit
     * @param int $precision
     * @return self
     * @throws Exception
     */
    abstract public function round(VolumeUnit|int $unit, int $precision = 0): static;

    abstract public function modulo(self|float $volume, VolumeUnit|int|null $unit = null): static;

    abstract public function min(self|float $min, VolumeUnit|int|null $unit = null): static;

    abstract public function max(self|float $max, VolumeUnit|int|null $unit = null): static;

    final public function clamp(
        self|float          $min,
        self|float          $max,
        VolumeUnit|int|null $minUnit = null,
        VolumeUnit|int|null $maxUnit = null
    ): static
    {
        return $this->max($min, $minUnit)->min($max, $maxUnit);
    }

    final public function isEqualTo(
        self|float          $volume,
        VolumeUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        $volume = $volume instanceof self ? $volume : new static($volume, $unit);
        return floatsEqual($this->value, $volume->getValue($this->unit), $precision);
    }

    final public function isNotEqualTo(
        self|float          $volume,
        VolumeUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return !$this->isEqualTo($volume, $unit, $precision);
    }

    final public function isLessThan(self|float $volume, VolumeUnit|int|null $unit = null): bool
    {
        return $volume instanceof self
            ? floatsLessThan($this->value, $volume->getValue($this->unit))
            : $this->isLessThan(new static($volume, $unit));
    }

    final public function isLessThanOrEqualTo(
        self|float          $volume,
        VolumeUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return $volume instanceof self
            ? $this->isLessThan($volume) || $this->isEqualTo($volume, precision: $precision)
            : $this->isLessThanOrEqualTo(new static($volume, $unit));
    }

    final public function isGreaterThan(self|float $volume, VolumeUnit|int|null $unit = null): bool
    {
        return $volume instanceof self
            ? floatsGreaterThan($this->value, $volume->getValue($this->unit))
            : $this->isGreaterThan(new static($volume, $unit));
    }

    final public function isGreaterThanOrEqualTo(
        self|float          $volume,
        VolumeUnit|int|null $unit = null,
        int                 $precision = DEFAULT_PRECISION
    ): bool
    {
        return $volume instanceof self
            ? $this->isGreaterThan($volume) || $this->isEqualTo($volume, precision: $precision)
            : $this->isGreaterThanOrEqualTo(new static($volume, $unit));
    }

    final public function format(VolumeUnit|int $unit, int $decimals = 0, Format $format = Format::SYMBOL): string
    {
        return $format->formatVolume(
            $this,
            $unit instanceof VolumeUnit ? $unit : VolumeUnit::getById($unit),
            $decimals
        );
    }

    /**
     * @param array<VolumeUnit|int> $units
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
        usort($units, function (VolumeUnit|int $a, VolumeUnit|int $b) {
            $a = $a instanceof VolumeUnit ? $a : VolumeUnit::getById($a);
            $b = $b instanceof VolumeUnit ? $b : VolumeUnit::getById($b);
            return $b->baseUnitsPer <=> $a->baseUnitsPer;
        });

        $result = [];
        $remaining = new VolumeImmutable($this->value, $this->unit);
        foreach ($units as $i => $unit) {
            $isLastUnit = $i === count($units) - 1;

            if ($isLastUnit) {
                $portion = $remaining;
                $portionDecimals = $decimals;
            } else {
                $portion = new VolumeImmutable(floor($remaining->getValue($unit)), $unit);
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

    final public function toImmutable(): VolumeImmutable
    {
        return new VolumeImmutable($this->value, $this->unit);
    }

    final public function toMutable(): Volume
    {
        return new Volume($this->value, $this->unit);
    }

    final public function getUnit(): VolumeUnit
    {
        return $this->unit;
    }
}
