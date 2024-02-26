<?php

namespace Cjfulford\Measurements;

use InvalidArgumentException;

readonly class LengthUnit extends Unit
{
    public const int KILOMETRE  = 1;
    public const int METRE      = 2;
    public const int CENTIMETRE = 3;
    public const int MILLIMETRE = 4;
    public const int INCH       = 5;
    public const int FOOT       = 6;
    public const int YARD       = 7;
    public const int MILE       = 8;

    private const array UNITS = [
        self::KILOMETRE  => [
            'name'         => 'kilometre',
            'pluralName'   => 'kilometres',
            'acronym'      => 'km',
            'symbol'       => 'km',
            'baseUnitsPer' => 10e3,
        ],
        self::METRE      => [
            'name'         => 'metre',
            'pluralName'   => 'metres',
            'acronym'      => 'm',
            'symbol'       => 'm',
            'baseUnitsPer' => 10e0,
        ],
        self::CENTIMETRE => [
            'name'         => 'centimetre',
            'pluralName'   => 'centimetres',
            'acronym'      => 'cm',
            'symbol'       => 'cm',
            'baseUnitsPer' => 10e-2,
        ],
        self::MILLIMETRE => [
            'name'         => 'millimetre',
            'pluralName'   => 'millimetres',
            'acronym'      => 'mm',
            'symbol'       => 'mm',
            'baseUnitsPer' => 10e-3,
        ],
        self::INCH       => [
            'name'         => 'inch',
            'pluralName'   => 'inches',
            'acronym'      => 'in',
            'symbol'       => '"',
            'baseUnitsPer' => 0.0254,
        ],
        self::FOOT       => [
            'name'         => 'foot',
            'pluralName'   => 'feet',
            'acronym'      => 'ft',
            'symbol'       => "'",
            'baseUnitsPer' => 0.3048,
        ],
        self::YARD       => [
            'name'         => 'yard',
            'pluralName'   => 'yards',
            'acronym'      => 'yd',
            'symbol'       => 'yd',
            'baseUnitsPer' => 0.9144,
        ],
        self::MILE       => [
            'name'         => 'mile',
            'pluralName'   => 'miles',
            'acronym'      => 'mi',
            'symbol'       => 'mi',
            'baseUnitsPer' => 1609.344,
        ],
    ];

    public function __construct(int $id)
    {
        $unit = self::UNITS[$id];

        if ($unit === null) {
            throw new InvalidArgumentException("Invalid unit ID: $id");
        }

        parent::__construct(
            id          : $id,
            baseUnitsPer: $unit['baseUnitsPer'],
            name        : $unit['name'],
            pluralName  : $unit['pluralName'],
            acronym     : $unit['acronym'],
            symbol      : $unit['symbol']
        );
    }
}
