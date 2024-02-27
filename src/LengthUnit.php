<?php

namespace Cjfulford\Measurements;

class LengthUnit extends Unit
{
    public const int KILOMETRE  = 1;
    public const int METRE      = 2;
    public const int CENTIMETRE = 3;
    public const int MILLIMETRE = 4;
    public const int INCH       = 5;
    public const int FOOT       = 6;
    public const int YARD       = 7;
    public const int MILE       = 8;

    final protected static function buildDefaultUnits(): void
    {
        if (self::$units[static::class] !== null) {
            return;
        }

        self::$units[static::class] = [];

        new self(
            id          : self::KILOMETRE,
            baseUnitsPer: 10e3,
            name        : 'kilometre',
            pluralName  : 'kilometres',
            acronym     : 'km',
            symbol      : 'km'
        );
        new self(
            id          : self::METRE,
            baseUnitsPer: 10e0,
            name        : 'metre',
            pluralName  : 'metres',
            acronym     : 'm',
            symbol      : 'm'
        );
        new self(
            id          : self::CENTIMETRE,
            baseUnitsPer: 10e-2,
            name        : 'centimetre',
            pluralName  : 'centimetres',
            acronym     : 'cm',
            symbol      : 'cm'
        );
        new self(
            id          : self::MILLIMETRE,
            baseUnitsPer: 10e-3,
            name        : 'millimetre',
            pluralName  : 'millimetres',
            acronym     : 'mm',
            symbol      : 'mm'
        );
        new self(
            id          : self::INCH,
            baseUnitsPer: 0.0254,
            name        : 'inch',
            pluralName  : 'inches',
            acronym     : 'in',
            symbol      : '"'
        );
        new self(
            id          : self::FOOT,
            baseUnitsPer: 0.3048,
            name        : 'foot',
            pluralName  : 'feet',
            acronym     : 'ft',
            symbol      : "'"
        );
        new self(
            id          : self::YARD,
            baseUnitsPer: 0.9144,
            name        : 'yard',
            pluralName  : 'yards',
            acronym     : 'yd',
            symbol      : 'yd'
        );
        new self(
            id          : self::MILE,
            baseUnitsPer: 1609.344,
            name        : 'mile',
            pluralName  : 'miles',
            acronym     : 'mi',
            symbol      : 'mi'
        );
    }
}
