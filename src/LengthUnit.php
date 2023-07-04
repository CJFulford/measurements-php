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
    // Metric
    public const TERAMETRE  = 15;
    public const GIGAMETRE  = 16;
    public const MEGAMETRE  = 17;
    public const KILOMETRE  = 18;
    public const HECTOMETRE = 19;
    public const DECAMETRE  = 20;
    public const METRE      = 21;
    public const DECIMETRE  = 22;
    public const CENTIMETRE = 23;
    public const MILLIMETRE = 24;
    public const MICROMETRE = 25;
    public const NANOMETRE  = 26;
    public const PICOMETRE  = 27;

    final public static function getUnitDefinitions(): array
    {
        return [
            /*
             * Imperial
             */
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
            /*
             * Metric
             */
            self::TERAMETRE     => [
                self::DEF_NAME           => 'terametre',
                self::DEF_SYMBOL         => 'mT',
                self::DEF_BASE_UNITS_PER => 10e12
            ],
            self::GIGAMETRE     => [
                self::DEF_NAME           => 'gigametre',
                self::DEF_SYMBOL         => 'mG',
                self::DEF_BASE_UNITS_PER => 10e9
            ],
            self::MEGAMETRE     => [
                self::DEF_NAME           => 'megametre',
                self::DEF_SYMBOL         => 'mM',
                self::DEF_BASE_UNITS_PER => 10e6
            ],
            self::KILOMETRE     => [
                self::DEF_NAME           => 'kilometre',
                self::DEF_SYMBOL         => 'mk',
                self::DEF_BASE_UNITS_PER => 10e3
            ],
            self::HECTOMETRE    => [
                self::DEF_NAME           => 'hectometre',
                self::DEF_SYMBOL         => 'mh',
                self::DEF_BASE_UNITS_PER => 10e2
            ],
            self::DECAMETRE     => [
                self::DEF_NAME           => 'decametre',
                self::DEF_SYMBOL         => 'mda',
                self::DEF_BASE_UNITS_PER => 10e1
            ],
            self::METRE         => [
                self::DEF_NAME           => 'metre',
                self::DEF_SYMBOL         => 'm',
                self::DEF_BASE_UNITS_PER => 10e0
            ],
            self::DECIMETRE     => [
                self::DEF_NAME           => 'decimetre',
                self::DEF_SYMBOL         => 'md',
                self::DEF_BASE_UNITS_PER => 10e-1
            ],
            self::CENTIMETRE    => [
                self::DEF_NAME           => 'centimetre',
                self::DEF_SYMBOL         => 'mc',
                self::DEF_BASE_UNITS_PER => 10e-2
            ],
            self::MILLIMETRE    => [
                self::DEF_NAME           => 'millimetre',
                self::DEF_SYMBOL         => 'mm',
                self::DEF_BASE_UNITS_PER => 10e-3
            ],
            self::MICROMETRE    => [
                self::DEF_NAME           => 'micrometre',
                self::DEF_SYMBOL         => 'mμ',
                self::DEF_BASE_UNITS_PER => 10e-6
            ],
            self::NANOMETRE     => [
                self::DEF_NAME           => 'nanometre',
                self::DEF_SYMBOL         => 'mn',
                self::DEF_BASE_UNITS_PER => 10e-9
            ],
            self::PICOMETRE     => [
                self::DEF_NAME           => 'picometre',
                self::DEF_SYMBOL         => 'mp',
                self::DEF_BASE_UNITS_PER => 10e-12
            ],
        ];
    }
}
