<?php

namespace Cjfulford\Measurements;

use InvalidArgumentException;

class AreaUnit extends Unit
{
    public const SQUARE_METRE = 1;
    public const SQUARE_KILOMETRE = 2;
    public const SQUARE_CENTIMETRE = 3;
    public const SQUARE_MILLIMETRE = 4;
    public const SQUARE_INCH = 5;
    public const SQUARE_FOOT = 6;
    public const SQUARE_YARD = 7;
    public const SQUARE_MILE = 8;

    public readonly LengthUnit $correspondingLengthUnit;

    final public function __construct(
        int    $id,
        string $name,
        string $pluralName,
        string $acronym,
        int    $correspondingLengthUnitId
    )
    {
        $this->correspondingLengthUnit = LengthUnit::getById($correspondingLengthUnitId);
        parent::__construct(
            id: $id,
            baseUnitsPer: $this->correspondingLengthUnit->baseUnitsPer ** 2,
            name: $name,
            pluralName: $pluralName,
            acronym: $acronym,
            symbol: $acronym
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
            id: self::SQUARE_KILOMETRE,
            name: 'square kilometre',
            pluralName: 'square kilometres',
            acronym: 'km²',
            correspondingLengthUnitId: LengthUnit::KILOMETRE
        );
        new self(
            id: self::SQUARE_METRE,
            name: 'square metre',
            pluralName: 'square metres',
            acronym: 'm²',
            correspondingLengthUnitId: LengthUnit::METRE
        );
        new self(
            id: self::SQUARE_CENTIMETRE,
            name: 'square centimetre',
            pluralName: 'square centimetres',
            acronym: 'cm²',
            correspondingLengthUnitId: LengthUnit::CENTIMETRE
        );
        new self(
            id: self::SQUARE_MILLIMETRE,
            name: 'square millimetre',
            pluralName: 'square millimetres',
            acronym: 'mm²',
            correspondingLengthUnitId: LengthUnit::MILLIMETRE
        );
        new self(
            id: self::SQUARE_INCH,
            name: 'square inch',
            pluralName: 'square inches',
            acronym: 'in²',
            correspondingLengthUnitId: LengthUnit::INCH
        );
        new self(
            id: self::SQUARE_FOOT,
            name: 'square foot',
            pluralName: 'square feet',
            acronym: 'ft²',
            correspondingLengthUnitId: LengthUnit::FOOT
        );
        new self(
            id: self::SQUARE_YARD,
            name: 'square yard',
            pluralName: 'square yards',
            acronym: 'yd²',
            correspondingLengthUnitId: LengthUnit::YARD
        );
        new self(
            id: self::SQUARE_MILE,
            name: 'square mile',
            pluralName: 'square miles',
            acronym: 'mi²',
            correspondingLengthUnitId: LengthUnit::MILE
        );
    }
}
