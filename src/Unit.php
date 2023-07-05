<?php

namespace Cjfulford\Measurements;

use Exception;

abstract class Unit
{
    // Metric
    public const KILOMETRE  = 1;
    public const METRE      = 2;
    public const CENTIMETRE = 3;
    public const MILLIMETRE = 4;
    public const MICROMETRE = 5;
    public const NANOMETRE  = 6;
    // Imperial
    public const INCH = 7;
    public const FOOT = 8;
    public const YARD = 9;
    public const MILE = 10;

    private const DEF_BASE_UNITS_PER = 'baseUnitsPer';
    private const DEF_NAME           = 'name';
    private const DEF_PLURAL_NAME    = 'pluralName';
    private const DEF_ACRONYM        = 'acronym';

    private int    $id;
    private float  $baseUnitsPer;
    private string $name;
    private string $pluralName;
    private string $acronym;

    public function __construct(
        int    $id,
        int    $baseUnitsPerPower,
        string $namePrefix,
        string $acronymPostfix,
    ) {
        $this->id = $id;

        $definitions = static::getUnitDefinitions();

        if (!isset($definitions[$id])) {
            throw new Exception('No definition for unit');
        }

        $definition = $definitions[$id];

        // raise the base units per to the power depending on the specific unit
        $this->baseUnitsPer = pow($definition[self::DEF_BASE_UNITS_PER], $baseUnitsPerPower);
        $this->name         = $namePrefix . $definition[self::DEF_NAME];
        $this->pluralName   = $namePrefix . ($definition[self::DEF_PLURAL_NAME] ?? $this->name . 's');
        $acronym            = $definition[self::DEF_ACRONYM];
        $this->acronym      = $acronym ? $acronym . $acronymPostfix : '';
    }

    final public function getId(): int
    {
        return $this->id;
    }

    final public function getBaseUnitsPer(): float
    {
        return $this->baseUnitsPer;
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function getPluralName(): string
    {
        return $this->pluralName;
    }

    final public function getAcronym(): string
    {
        return $this->acronym;
    }

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
                self::DEF_ACRONYM        => 'in'
            ],
            self::FOOT       => [
                self::DEF_NAME           => 'foot',
                self::DEF_PLURAL_NAME    => 'feet',
                self::DEF_BASE_UNITS_PER => 0.3048,
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
                self::DEF_ACRONYM        => 'km',
                self::DEF_BASE_UNITS_PER => 10e3
            ],
            self::METRE      => [
                self::DEF_NAME           => 'metre',
                self::DEF_ACRONYM        => 'm',
                self::DEF_BASE_UNITS_PER => 10e0
            ],
            self::CENTIMETRE => [
                self::DEF_NAME           => 'centimetre',
                self::DEF_ACRONYM        => 'cm',
                self::DEF_BASE_UNITS_PER => 10e-2
            ],
            self::MILLIMETRE => [
                self::DEF_NAME           => 'millimetre',
                self::DEF_ACRONYM        => 'mm',
                self::DEF_BASE_UNITS_PER => 10e-3
            ],
            self::MICROMETRE => [
                self::DEF_NAME           => 'micrometre',
                self::DEF_ACRONYM        => 'μm',
                self::DEF_BASE_UNITS_PER => 10e-6
            ],
            self::NANOMETRE  => [
                self::DEF_NAME           => 'nanometre',
                self::DEF_ACRONYM        => 'nm',
                self::DEF_BASE_UNITS_PER => 10e-9
            ],
        ];
    }
}
