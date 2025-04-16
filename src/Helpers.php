<?php

namespace Cjfulford\Measurements\Helpers;

function floatsEqual(float $a, float $b, int $toNumberOfDecimals = 5): bool
{
    $a = round($a, $toNumberOfDecimals);
    $b = round($b, $toNumberOfDecimals);
    return $a === $b;
}

function floatsGreaterThan(float $a, float $b, int $toNumberOfDecimals = 5): bool
{
    $a = round($a, $toNumberOfDecimals);
    $b = round($b, $toNumberOfDecimals);
    return $a > $b;
}

function floatsLessThan(float $a, float $b, int $toNumberOfDecimals = 5): bool
{
    $a = round($a, $toNumberOfDecimals);
    $b = round($b, $toNumberOfDecimals);
    return $a < $b;
}
