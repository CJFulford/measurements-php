<?php

namespace Cjfulford\Measurements;

class LengthUnit extends Unit
{
    // Imperial
    public const TWIP          = 1;
    public const THOU          = 2;
    public const BARLEYCORN    = 3;
    public const INCH          = 4;
    public const HAND          = 5;
    public const FOOT          = 6;
    public const YARD          = 7;
    public const CHAIN         = 8;
    public const FURLONG       = 9;
    public const MILE          = 10;
    public const LEAGUE        = 11;
    public const FATHOM        = 12;
    public const CABLE         = 13;
    public const NAUTICAL_MILE = 14;

    final protected static function getUnitDefinitions(): array
    {
        return [
            self::TWIP          => [
                self::DEF_NAME           => 'twip',
                self::DEF_BASE_UNITS_PER => 0.0000176389,
            ],
            self::THOU          => [
                self::DEF_NAME           => 'thou',
                self::DEF_BASE_UNITS_PER => 0.0000254,
                self::DEF_SYMBOL         => 'th',
            ],
            self::BARLEYCORN    => [
                self::DEF_NAME           => 'barleycorn',
                self::DEF_BASE_UNITS_PER => 0.0084667,
            ],
            self::INCH          => [
                self::DEF_NAME           => 'inch',
                self::DEF_PLURAL_NAME    => 'inches',
                self::DEF_BASE_UNITS_PER => 0.0254,
                self::DEF_SYMBOL         => "'",
                self::DEF_ACRONYM        => 'in'
            ],
            self::HAND          => [
                self::DEF_NAME           => 'hand',
                self::DEF_BASE_UNITS_PER => 0.1016,
                self::DEF_SYMBOL         => 'hh',
            ],
            self::FOOT          => [
                self::DEF_NAME           => 'foot',
                self::DEF_PLURAL_NAME    => 'feet',
                self::DEF_BASE_UNITS_PER => 0.3048,
                self::DEF_SYMBOL         => "'",
                self::DEF_ACRONYM        => 'ft'
            ],
            self::YARD          => [
                self::DEF_NAME           => 'yard',
                self::DEF_BASE_UNITS_PER => 0.9144,
                self::DEF_ACRONYM        => 'yd'
            ],
            self::CHAIN         => [
                self::DEF_NAME           => 'chain',
                self::DEF_BASE_UNITS_PER => 20.1168,
                self::DEF_ACRONYM        => 'ch'
            ],
            self::FURLONG       => [
                self::DEF_NAME           => 'furlong',
                self::DEF_BASE_UNITS_PER => 201.168,
                self::DEF_ACRONYM        => 'fur'
            ],
            self::MILE          => [
                self::DEF_NAME           => 'mile',
                self::DEF_BASE_UNITS_PER => 1609.344,
                self::DEF_ACRONYM        => 'mi'
            ],
            self::LEAGUE        => [
                self::DEF_NAME           => 'league',
                self::DEF_BASE_UNITS_PER => 4828.032,
                self::DEF_ACRONYM        => 'lea'
            ],
            self::FATHOM        => [
                self::DEF_NAME           => 'fathom',
                self::DEF_BASE_UNITS_PER => 1.852,
                self::DEF_ACRONYM        => 'ftm'
            ],
            self::CABLE         => [
                self::DEF_NAME           => 'cable',
                self::DEF_BASE_UNITS_PER => 185.2,
            ],
            self::NAUTICAL_MILE => [
                self::DEF_NAME           => 'nautical mile',
                self::DEF_BASE_UNITS_PER => 1852,
                self::DEF_ACRONYM        => 'nmi'
            ],
        ];
    }
}
