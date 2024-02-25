<?php

namespace Cjfulford\Measurements;

use InvalidArgumentException;

readonly class AreaUnit extends Unit
{
    public const SQUARE_METRE      = 1;
    public const SQUARE_KILOMETRE  = 2;
    public const SQUARE_CENTIMETRE = 3;
    public const SQUARE_MILLIMETRE = 4;
    public const SQUARE_INCH       = 5;
    public const SQUARE_FOOT       = 6;
    public const SQUARE_YARD       = 7;
    public const SQUARE_MILE       = 8;

    public const BASE_UNIT = self::SQUARE_METRE;

    private const UNITS = [
        self::SQUARE_KILOMETRE  => [
            'name'                      => 'kilometre',
            'pluralName'                => 'kilometres',
            'acronym'                   => 'km²',
            'correspondingLengthUnitId' => LengthUnit::KILOMETRE,
        ],
        self::SQUARE_METRE      => [
            'name'                      => 'metre',
            'pluralName'                => 'metres',
            'acronym'                   => 'm²',
            'correspondingLengthUnitId' => LengthUnit::METRE,
        ],
        self::SQUARE_CENTIMETRE => [
            'name'                      => 'centimetre',
            'pluralName'                => 'centimetres',
            'acronym'                   => 'cm²',
            'correspondingLengthUnitId' => LengthUnit::CENTIMETRE,
        ],
        self::SQUARE_MILLIMETRE => [
            'name'                      => 'millimetre',
            'pluralName'                => 'millimetres',
            'acronym'                   => 'mm²',
            'correspondingLengthUnitId' => LengthUnit::MILLIMETRE,
        ],
        self::SQUARE_INCH       => [
            'name'                      => 'inch',
            'pluralName'                => 'inches',
            'acronym'                   => 'in²',
            'correspondingLengthUnitId' => LengthUnit::INCH,
        ],
        self::SQUARE_FOOT       => [
            'name'                      => 'foot',
            'pluralName'                => 'feet',
            'acronym'                   => 'ft²',
            'correspondingLengthUnitId' => LengthUnit::FOOT,
        ],
        self::SQUARE_YARD       => [
            'name'                      => 'yard',
            'pluralName'                => 'yards',
            'acronym'                   => 'yd²',
            'correspondingLengthUnitId' => LengthUnit::YARD,
        ],
        self::SQUARE_MILE       => [
            'name'                      => 'mile',
            'pluralName'                => 'miles',
            'acronym'                   => 'mi²',
            'correspondingLengthUnitId' => LengthUnit::MILE,
        ],
    ];

    public LengthUnit $correspondingLengthUnit;
    public bool       $isBaseUnit;

    public function __construct(int $id)
    {
        $unit = self::UNITS[$id];

        if (!isset($unit)) {
            throw new InvalidArgumentException("Invalid unit id: $id");
        }

        $this->correspondingLengthUnit = new LengthUnit($unit['correspondingLengthUnitId']);
        $this->isBaseUnit              = $id === self::BASE_UNIT;

        parent::__construct(
            id          : $id,
            baseUnitsPer: pow($this->correspondingLengthUnit->baseUnitsPer, 2),
            name        : $unit['name'],
            pluralName  : $unit['pluralName'],
            acronym     : $unit['acronym'],
            symbol      : $unit['acronym']
        );
    }
}
