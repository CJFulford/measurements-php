<?php

namespace Cjfulford\Measurements;

use DANJER\model\Length;

enum Format
{
    case ACRONYM;
    case NAME;
    case SYMBOL;

    function formatLength(Length $length, LengthUnit $unit, int $decimals): string
    {
        $value  = number_format($length->getValue($unit), $decimals);
        $append = match ($this) {
            self::ACRONYM => $unit->acronym,
            self::NAME    => $unit->name,
            self::SYMBOL  => $unit->symbol,
        };
        return trim($value . $append);
    }

    function formatArea(Area $area, AreaUnit $unit, int $decimals): string
    {
        $value  = number_format($area->getValue($unit), $decimals);
        $append = match ($this) {
            self::ACRONYM => $unit->acronym,
            self::NAME    => $unit->name,
            self::SYMBOL  => $unit->symbol,
        };
        return trim($value . $append);
    }
}
