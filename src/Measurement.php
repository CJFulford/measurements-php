<?php

namespace Cjfulford\Measurements;

use Exception;

abstract class Measurement
{
    /** @var float Will always be in base units */
    protected float $value;
    private bool    $isMutable;
    private string  $unitClass;

    protected function __construct(float $value, Unit|int $unit, bool $isMutable, string $unitClass)
    {
        // get the unit object for the id
        $unit = is_int($unit) ? new $unitClass($unit) : $unit;

        // always convert the value so the value is in the base units
        $this->value     = $value * $unit->getBaseUnitsPer();
        $this->isMutable = $isMutable;
        $this->unitClass = $unitClass;
    }

    final protected function checkUnitCompatibility(Unit $unit): void
    {
        if (!($unit instanceof $this->unitClass)) {
            throw new Exception('Unit is incompatible with measurement');
        }
    }

    /**
     * Returns the value of the measurement in the requested unit.
     *
     * @param Unit $unit
     * @return float
     * @throws Exception
     */
    final public function getValue(Unit $unit, $precision = 5): float
    {
        $this->checkUnitCompatibility($unit);
        return round($this->value / $unit->getBaseUnitsPer(), $precision);
    }

    final public function isMutable(): bool
    {
        return $this->isMutable;
    }

    /**
     * Throws an exception if the measurement is immutable
     *
     * @return void
     * @throws Exception
     */
    final protected function checkMutability(): void
    {
        if (!$this->isMutable()) {
            throw new Exception('Attempting to alter measurement but measurement is not mutable');
        }
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
     * determine if this is equal to another measurement
     *
     * @param Measurement|float $value if this value is a Length, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a Length
     * @param int $precision how many decimals to compare to
     * @return bool
     * @throws Exception
     */
    public function equals(Measurement|float $value, Unit|int|null $unit = null, int $precision = 5): bool
    {
        // add the value of the incoming measurement to this object
        if ($value instanceof static) {
            $thisValue = round($this->value, $precision);
            $thatValue = round($value->value, $precision);
            return $thisValue === $thatValue;
        }

        if ($unit === null) {
            throw new Exception('No unit provided');
        }

        // ensure that $unit is a LengthUnit
        $unit = $unit instanceof $this->unitClass ? $unit : new $this->unitClass($unit);
        // recurse on this function now that the argument is a Length
        return $this->equals(new static($value, $unit));
    }

    /**
     * adds the provided length to this length
     *
     * @param Measurement|float $value if this value is a Length, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a Length
     * @return $this
     * @throws Exception
     */
    public function add(Measurement|float $value, Unit|int|null $unit = null): self
    {
        // add the value of the incoming measurement to this object
        if ($value instanceof static) {
            $this->value += $value->value;
            return $this;
        }

        if ($unit === null) {
            throw new Exception('No unit provided');
        }

        // ensure that $unit is a LengthUnit
        $unit = $unit instanceof $this->unitClass ? $unit : new $this->unitClass($unit);
        // recurse on this function now that the argument is a Length
        return $this->add(new static($value, $unit));
    }

    /**
     * subtracts the provided length from this length
     *
     * @param Measurement|float $value if this value is a Length, $unit is ignored
     * @param Unit|int|null $unit must be set if $value is a Length
     * @return $this
     * @throws Exception
     */
    public function sub(Measurement|float $value, Unit|int|null $unit = null): self
    {
        // add the value of the incoming measurement to this object
        if ($value instanceof static) {
            $this->value -= $value->value;
            return $this;
        }

        if ($unit === null) {
            throw new Exception('No unit provided');
        }

        // ensure that $unit is a LengthUnit
        $unit = $unit instanceof $this->unitClass ? $unit : new $this->unitClass($unit);
        // recurse on this function now that the argument is a Length
        return $this->sub(new static($value, $unit));
    }
}
