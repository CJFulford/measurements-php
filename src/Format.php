<?php

namespace Cjfulford\Measurements;

enum Format
{
    case ACRONYM;
    case NAME;
    case SYMBOL;

    function formatLength(AbstractLength $length, LengthUnit $unit, int $decimals): string
    {
        $value = number_format($length->getValue($unit), $decimals);
        $append = match ($this) {
            self::ACRONYM => $unit->acronym,
            self::NAME => $unit->name,
            self::SYMBOL => $unit->symbol,
        };
        return trim($value . $append);
    }

    function formatArea(AbstractArea $area, AreaUnit $unit, int $decimals): string
    {
        $value = number_format($area->getValue($unit), $decimals);
        $append = match ($this) {
            self::ACRONYM => $unit->acronym,
            self::NAME => $unit->name,
            self::SYMBOL => $unit->symbol,
        };
        return trim($value . $append);
    }

    function formatVolume(AbstractVolume $volume, VolumeUnit $unit, int $decimals): string
    {
        $value = number_format($volume->getValue($unit), $decimals);
        $append = match ($this) {
            self::ACRONYM => $unit->acronym,
            self::NAME => $unit->name,
            self::SYMBOL => $unit->symbol,
        };
        return trim($value . $append);
    }
}
