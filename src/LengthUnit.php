<?php

namespace Cjfulford\Measurements;

class LengthUnit extends Unit
{
    // Imperial
    public const INCH = 4;
    public const FOOT = 6;
    public const YARD = 7;
    public const MILE = 10;
    // Metric
    public const KILOMETRE  = 18;
    public const METRE      = 21;
    public const CENTIMETRE = 23;
    public const MILLIMETRE = 24;
    public const MICROMETRE = 25;
    public const NANOMETRE  = 26;

    final public static function getUnitDefinitions(): array
    {
        return [
            /*
             * Imperial
             */
            self::INCH       => [
                self::DEF_NAME           => 'inch',
                self::DEF_PLURAL_NAME    => 'inches',
                self::DEF_BASE_UNITS_PER => 0.0254,
                self::DEF_SYMBOL         => "'",
                self::DEF_ACRONYM        => 'in'
            ],
            self::FOOT       => [
                self::DEF_NAME           => 'foot',
                self::DEF_PLURAL_NAME    => 'feet',
                self::DEF_BASE_UNITS_PER => 0.3048,
                self::DEF_SYMBOL         => "'",
                self::DEF_ACRONYM        => 'ft'
            ],
            self::YARD       => [
                self::DEF_NAME           => 'yard',
                self::DEF_BASE_UNITS_PER => 0.9144,
                self::DEF_ACRONYM        => 'yd'
            ],
            self::MILE       => [
                self::DEF_NAME           => 'mile',
                self::DEF_BASE_UNITS_PER => 1609.344,
                self::DEF_ACRONYM        => 'mi'
            ],
            /*
             * Metric
             */
            self::KILOMETRE  => [
                self::DEF_NAME           => 'kilometre',
                self::DEF_SYMBOL         => 'mk',
                self::DEF_BASE_UNITS_PER => 10e3
            ],
            self::METRE      => [
                self::DEF_NAME           => 'metre',
                self::DEF_SYMBOL         => 'm',
                self::DEF_BASE_UNITS_PER => 10e0
            ],
            self::CENTIMETRE => [
                self::DEF_NAME           => 'centimetre',
                self::DEF_SYMBOL         => 'mc',
                self::DEF_BASE_UNITS_PER => 10e-2
            ],
            self::MILLIMETRE => [
                self::DEF_NAME           => 'millimetre',
                self::DEF_SYMBOL         => 'mm',
                self::DEF_BASE_UNITS_PER => 10e-3
            ],
            self::MICROMETRE => [
                self::DEF_NAME           => 'micrometre',
                self::DEF_SYMBOL         => 'mμ',
                self::DEF_BASE_UNITS_PER => 10e-6
            ],
            self::NANOMETRE  => [
                self::DEF_NAME           => 'nanometre',
                self::DEF_SYMBOL         => 'mn',
                self::DEF_BASE_UNITS_PER => 10e-9
            ],
        ];
    }
}
