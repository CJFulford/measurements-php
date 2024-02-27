<?php

namespace Cjfulford\Measurements;

use InvalidArgumentException;

class AreaUnit extends Unit
{
    public const SQUARE_METRE      = 1;
    public const SQUARE_KILOMETRE  = 2;
    public const SQUARE_CENTIMETRE = 3;
    public const SQUARE_MILLIMETRE = 4;
    public const SQUARE_INCH       = 5;
    public const SQUARE_FOOT       = 6;
    public const SQUARE_YARD       = 7;
    public const SQUARE_MILE       = 8;

    public readonly LengthUnit $correspondingLengthUnit;

    final public function __construct(
        int    $id,
        string $name,
        string $pluralName,
        string $acronym,
        int    $correspondingLengthUnitId
    ) {
        $this->correspondingLengthUnit = LengthUnit::getById($correspondingLengthUnitId);
        parent::__construct(
            id          : $id,
            baseUnitsPer: $this->correspondingLengthUnit->baseUnitsPer ** 2,
            name        : $name,
            pluralName  : $pluralName,
            acronym     : $acronym,
            symbol      : $acronym
        );
    }

    protected static function checkForUniqueness(self|Unit $newUnit): void
    {
        if (!$newUnit instanceof self) {
            throw new InvalidArgumentException('Unit must be an instance of ' . self::class);
        }

        parent::checkForUniqueness($newUnit);

        foreach (self::$units[static::class] as $unit) {
            if ($unit->correspondingLengthUnit->id === $newUnit->correspondingLengthUnit->id) {
                throw new InvalidArgumentException(
                    "Unit corresponding length unit ID $newUnit->correspondingLengthUnit->id already exists"
                );
            }
        }
    }

    final protected static function buildDefaultUnits(): void
    {
        if (isset(self::$units[static::class])) {
            return;
        }

        self::$units[static::class] = [];

        new self(
            id                       : self::SQUARE_KILOMETRE,
            name                     : 'kilometre',
            pluralName               : 'kilometres',
            acronym                  : 'km²',
            correspondingLengthUnitId: LengthUnit::KILOMETRE
        );
        new self(
            id                       : self::SQUARE_METRE,
            name                     : 'metre',
            pluralName               : 'metres',
            acronym                  : 'm²',
            correspondingLengthUnitId: LengthUnit::METRE
        );
        new self(
            id                       : self::SQUARE_CENTIMETRE,
            name                     : 'centimetre',
            pluralName               : 'centimetres',
            acronym                  : 'cm²',
            correspondingLengthUnitId: LengthUnit::CENTIMETRE
        );
        new self(
            id                       : self::SQUARE_MILLIMETRE,
            name                     : 'millimetre',
            pluralName               : 'millimetres',
            acronym                  : 'mm²',
            correspondingLengthUnitId: LengthUnit::MILLIMETRE
        );
        new self(
            id                       : self::SQUARE_INCH,
            name                     : 'inch',
            pluralName               : 'inches',
            acronym                  : 'in²',
            correspondingLengthUnitId: LengthUnit::INCH
        );
        new self(
            id                       : self::SQUARE_FOOT,
            name                     : 'foot',
            pluralName               : 'feet',
            acronym                  : 'ft²',
            correspondingLengthUnitId: LengthUnit::FOOT
        );
        new self(
            id                       : self::SQUARE_YARD,
            name                     : 'yard',
            pluralName               : 'yards',
            acronym                  : 'yd²',
            correspondingLengthUnitId: LengthUnit::YARD
        );
        new self(
            id                       : self::SQUARE_MILE,
            name                     : 'mile',
            pluralName               : 'miles',
            acronym                  : 'mi²',
            correspondingLengthUnitId: LengthUnit::MILE
        );
    }
}
