<?php

namespace Cjfulford\Measurements;

use function Cjfulford\Measurements\Helpers\floatsEqual;

abstract class AbstractMeasurement
{
    protected float    $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    abstract public function mulByNumber(float $number): static;

    abstract public function divByNumber(float $number): static;
}