<?php

namespace Cjfulford\Measurements;

use Exception;

abstract class Measurement
{
    /** @var float Will always be in base units */
    protected float $value;
    private bool    $isMutable;
    private string  $unitClassName;

    protected function __construct(float $value, Unit $unit, bool $isMutable, string $unitClass)
    {
        // always convert the value so the value is in the base units
        $this->value         = $value * $unit->getBaseUnitsPer();
        $this->isMutable     = $isMutable;
        $this->unitClassName = $unitClass;
    }

    final protected function checkUnitCompatibility(Unit $unit): void
    {
        if (!is_subclass_of($unit, $this->unitClassName, false)) {
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
    final public function getValue(Unit $unit): float
    {
        $this->checkUnitCompatibility($unit);
        return $this->value / $unit->getBaseUnitsPer();
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
}
