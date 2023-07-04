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
                'name'       => 'Inch',
                'pluralName' => 'Inches',
                'inchesPer'  => 1,
                'symbol'     => "'",
                'acronym'    => 'in'
            ],
            self::FT => [
                'name'       => 'Foot',
                'pluralName' => 'Feet',
                'inchesPer'  => 12,
                'symbol'     => '"',
                'acronym'    => 'ft'
            ]
        ];
    }
}
