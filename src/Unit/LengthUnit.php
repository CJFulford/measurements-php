<?php

namespace Cjfulford\Measurements\Unit;

class LengthUnit extends Unit
{
    public const KILOMETRE  = 1;
    public const METRE      = 2;
    public const CENTIMETRE = 3;
    public const MILLIMETRE = 4;
    public const INCH       = 5;
    public const FOOT       = 6;
    public const YARD       = 7;
    public const MILE       = 8;

    final protected static function buildDefaultUnits(): void
    {
        if (isset(self::$units[static::class])) {
            return;
        }

        self::$units[static::class] = [];

        new self(
            id          : self::KILOMETRE,
            baseUnitsPer: 1000,
            name        : 'kilometre',
            pluralName  : 'kilometres',
            acronym     : 'km',
            symbol      : 'km'
        );
        new self(
            id          : self::METRE,
            baseUnitsPer: 1,
            name        : 'metre',
            pluralName  : 'metres',
            acronym     : 'm',
            symbol      : 'm'
        );
        new self(
            id          : self::CENTIMETRE,
            baseUnitsPer: 0.01,
            name        : 'centimetre',
            pluralName  : 'centimetres',
            acronym     : 'cm',
            symbol      : 'cm'
        );
        new self(
            id          : self::MILLIMETRE,
            baseUnitsPer: 0.001,
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
