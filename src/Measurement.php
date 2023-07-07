<?php

namespace Cjfulford\Measurements;

use Exception;

abstract class Measurement
{
    /** @var float Will always be in base units */
    protected float           $value;
    protected readonly float  $unitId;
    private bool              $isMutable = true;
    protected readonly string $unitClass;

    private const DEFAULT_PRECISION = 5;

    /**
     * @param float $value
     * @param Unit|int $unit
     * @param string $unitClass
     * @throws Exception
     */
    protected function __construct(float $value, Unit|int $unit, string $unitClass)
    {
        $this->unitClass = $unitClass;

        // get the unit object for the id
        if (is_int($unit)) {
            $unit = new $this->unitClass($unit);
        } else {
            $this->checkUnitCompatibility($unit);
        }

        $this->value  = $value;
        $this->unitId = $unit->getId();
    }

    final protected function checkUnitCompatibility(Unit $unit): void
    {
        if (!($unit instanceof $this->unitClass)) {
            throw new Exception('Unit is incompatible with measurement');
        }
    }

    abstract public function getUnit(): Unit;

    /**
     * Returns the value of the measurement in the requested unit.
     *
     * @param Unit|int $unit
     * @return float
     * @throws Exception
     */
    final public function getValue(Unit|int $unit): float
    {
        if (is_int($unit)) {
            $unit = new $this->unitClass($unit);
        } else {
            $this->checkUnitCompatibility($unit);
        }
        return $this->value * $this->getUnit()->getBaseUnitsPer() / $unit->getBaseUnitsPer();
    }

    final protected function setValue(float $value): self
    {
        if (!$this->isMutable()) {
            throw new Exception('Cannot set value. Instance is immutable');
        }
        $this->value = $value;
        return $this;
    }

    final public function isMutable(): bool
    {
        return $this->isMutable;
    }

    /**
     * Permanently marks this measurement as immutable
     *
     * @return $this
     */
    final public function setImmutable(): self
    {
        $this->isMutable = false;
        return $this;
    }

    /**
     * Determine if this is equal to another measurement. Compares the values in the units of this object
     *
     * @param Measurement|float $measurement if this value is a measurement, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a measurement
     * @param int $precision how many decimals to compare to
     * @return bool
     * @throws Exception
     */
    public function equals(
        Measurement|float $measurement,
        Unit|int|null     $unit = null,
        int               $precision = self::DEFAULT_PRECISION
    ): bool {
        if ($measurement instanceof static) {
            $difference = abs($this->value - $measurement->getValue($this->getUnit()));
            $epsilon    = pow(10, -1 * $precision);
            return $difference < $epsilon;
        }

        return $this->equals(new static($measurement, $unit));
    }

    /**
     * Adds the provided measurement to this measurement.
     * This instance is modified
     *
     * @param Measurement|float $measurement if this value is a measurement, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a measurement
     * @return $this
     * @throws Exception
     */
    public function add(Measurement|float $measurement, Unit|int|null $unit = null): self
    {
        return $measurement instanceof static
            ? $this->setValue($this->value += $measurement->getValue($this->getUnit()))
            : $this->add(new static($measurement, $unit));
    }

    /**
     * Subtracts the provided measurement from this measurement.
     * This instance is modified.
     *
     * @param Measurement|float $measurement if this value is a measurement, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a measurement
     * @return $this
     * @throws Exception
     */
    public function sub(Measurement|float $measurement, Unit|int|null $unit = null): self
    {
        return $measurement instanceof static
            ? $this->setValue($this->value -= $measurement->getValue($this->getUnit()))
            : $this->sub(new static($measurement, $unit));
    }

    /**
     * Multiplies the value of this measurement by the provided value.
     * This instance is modified.
     *
     * @param float $value
     * @return $this
     * @throws Exception
     */
    public function mulByNumber(float $value): self
    {
        return $this->setValue($this->value *= $value);
    }

    /**
     * Divides the value of this measurement by the provided value.
     * Provides no checks for division by 0.
     * This instance is modified.
     *
     * @param float $value
     * @return $this
     * @throws Exception
     */
    public function divByNumber(float $value): self
    {
        return $this->setValue($this->value /= $value);
    }

    /**
     * Determine if this measurement is greater than the provided measurement, check for equal to if corresponding parameter is set parameter is set
     * This instance is not modified.
     *
     * @param Measurement|float $measurement if this value is a measurement, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a measurement
     * @param bool $orEqualTo
     * @param int $precision
     * @return bool
     * @throws Exception
     */
    public function isGreaterThan(
        Measurement|float $measurement,
        Unit|int|null     $unit = null,
        bool              $orEqualTo = false,
        int               $precision = self::DEFAULT_PRECISION
    ): bool {
        if ($measurement instanceof static) {
            $thisValue = round($this->value, $precision);
            $thatValue = round($measurement->value, $precision);
            return $thisValue > $thatValue
                   || ($orEqualTo
                       && $this->equals(
                        measurement: $measurement,
                        precision  : $precision
                    ));
        }

        return $this->isGreaterThan(
            measurement: new static($measurement, $unit),
            orEqualTo  : $orEqualTo,
            precision  : $precision
        );
    }

    /**
     * Determine if this measurement is less than the provided measurement, check for equal to if corresponding parameter is set parameter is set
     * This instance is not modified.
     *
     * @param Measurement|float $measurement if this value is a measurement, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a measurement
     * @param bool $orEqualTo
     * @param int $precision
     * @return bool
     * @throws Exception
     */
    public function isLessThan(
        Measurement|float $measurement,
        Unit|int|null     $unit = null,
        bool              $orEqualTo = false,
        int               $precision = self::DEFAULT_PRECISION
    ): bool {
        if ($measurement instanceof static) {
            $thisValue = round($this->value, $precision);
            $thatValue = round($measurement->value, $precision);
            return $thisValue < $thatValue
                   || ($orEqualTo
                       && $this->equals(
                        measurement: $measurement,
                        precision  : $precision
                    ));
        }

        return $this->isGreaterThan(
            measurement: new static($measurement, $unit),
            orEqualTo  : $orEqualTo,
            precision  : $precision
        );
    }
}
