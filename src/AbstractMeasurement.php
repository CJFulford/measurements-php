<?php

namespace Cjfulford\Measurements;

use function Cjfulford\Measurements\Helpers\floatsEqual;

const DEFAULT_PRECISION = 5;

abstract class AbstractMeasurement
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    abstract public function mulByNumber(float $number): static;

    abstract public function divByNumber(float $number): static;

    final public function isZero(): bool
    {
        return floatsEqual($this->value, 0);
    }

    final public function isNotZero(): bool
    {
        return !$this->isZero();
    }

    final public function isGreaterThanZero(): bool
    {
        return $this->value > 0;
    }

    final public function isGreaterThanOrEqualToZero(): bool
    {
        return $this->value >= 0;
    }

    final public function isLessThanZero(): bool
    {
        return $this->value < 0;
    }

    final public function isLessThanOrEqualToZero(): bool
    {
        return $this->value <= 0;
    }

    abstract public static function zero(): static;
}
