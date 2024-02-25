<?php

namespace Cjfulford\Measurements\Helpers;

function floatsEqual(float $a, float $b, int $toNumberOfDecimals = 5): bool
{
    $epsilon = $toNumberOfDecimals === 5 ? 0.000001 : 0.1 / pow(10, $toNumberOfDecimals);
    return abs($a - $b) < $epsilon;
}
