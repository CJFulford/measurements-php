<?php

namespace Cjfulford\Measurements;

class LengthUnit extends Unit
{
    public const IN = 1;
    public const FT = 2;

    public function isInches(): bool
    {
        return $this->getId() === self::IN;
    }

    public function isFeet(): bool
    {
        return $this->getId() === self::FT;
    }

    final protected static function getUnitDefinitions(): array
    {
        return [
            self::IN => [
                self::DEF_NAME           => 'Inch',
                self::DEF_PLURAL_NAME    => 'Inches',
                self::DEF_BASE_UNITS_PER => 1,
                self::DEF_SYMBOL         => "'",
                self::DEF_ACRONYM        => 'in'
            ],
            self::FT => [
                self::DEF_NAME           => 'Foot',
                self::DEF_PLURAL_NAME    => 'Feet',
                self::DEF_BASE_UNITS_PER => 12,
                self::DEF_SYMBOL         => '"',
                self::DEF_ACRONYM        => 'ft'
            ]
        ];
    }
}
