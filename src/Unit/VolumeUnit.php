<?php

namespace Cjfulford\Measurements\Unit;

use InvalidArgumentException;

class VolumeUnit extends Unit
{
    public const CUBE_METRE = 1;
    public const CUBE_KILOMETRE = 2;
    public const CUBE_CENTIMETRE = 3;
    public const CUBE_MILLIMETRE = 4;
    public const CUBE_INCH = 5;
    public const CUBE_FOOT = 6;
    public const CUBE_YARD = 7;
    public const CUBE_MILE = 8;

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
            baseUnitsPer: $this->correspondingLengthUnit->baseUnitsPer ** 3,
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
            id: self::CUBE_KILOMETRE,
            name: 'cube kilometre',
            pluralName: 'cube kilometres',
            acronym: 'km³',
            correspondingLengthUnitId: LengthUnit::KILOMETRE
        );
        new self(
            id: self::CUBE_METRE,
            name: 'cube metre',
            pluralName: 'cube metres',
            acronym: 'm³',
            correspondingLengthUnitId: LengthUnit::METRE
        );
        new self(
            id: self::CUBE_CENTIMETRE,
            name: 'cube centimetre',
            pluralName: 'cube centimetres',
            acronym: 'cm³',
            correspondingLengthUnitId: LengthUnit::CENTIMETRE
        );
        new self(
            id: self::CUBE_MILLIMETRE,
            name: 'cube millimetre',
            pluralName: 'cube millimetres',
            acronym: 'mm³',
            correspondingLengthUnitId: LengthUnit::MILLIMETRE
        );
        new self(
            id: self::CUBE_INCH,
            name: 'cube inch',
            pluralName: 'cube inches',
            acronym: 'in³',
            correspondingLengthUnitId: LengthUnit::INCH
        );
        new self(
            id: self::CUBE_FOOT,
            name: 'cube foot',
            pluralName: 'cube feet',
            acronym: 'ft³',
            correspondingLengthUnitId: LengthUnit::FOOT
        );
        new self(
            id: self::CUBE_YARD,
            name: 'cube yard',
            pluralName: 'cube yards',
            acronym: 'yd³',
            correspondingLengthUnitId: LengthUnit::YARD
        );
        new self(
            id: self::CUBE_MILE,
            name: 'cube mile',
            pluralName: 'cube miles',
            acronym: 'mi³',
            correspondingLengthUnitId: LengthUnit::MILE
        );
    }
}
