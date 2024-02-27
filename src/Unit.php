<?php

namespace Cjfulford\Measurements;

use InvalidArgumentException;

abstract class Unit
{
    /**
     * @var array<string, array<static>>
     */
    protected static array $units = [];

    public function __construct(
        public readonly int    $id,
        public readonly float  $baseUnitsPer,
        public readonly string $name,
        public readonly string $pluralName,
        public readonly string $acronym,
        public readonly string $symbol,
    ) {
        static::buildDefaultUnits();

        static::checkForUniqueness($this);

        self::$units[static::class][] = $this;
    }

    protected static function checkForUniqueness(self $newUnit): void
    {
        foreach (self::$units[static::class] as $unit) {
            if ($unit->id === $newUnit->id) {
                throw new InvalidArgumentException("Unit ID $newUnit->id already exists");
            } elseif ($unit->baseUnitsPer === $newUnit->baseUnitsPer) {
                throw new InvalidArgumentException("Unit base units per $newUnit->baseUnitsPer already exists");
            } elseif ($unit->name === $newUnit->name) {
                throw new InvalidArgumentException("Unit name $newUnit->name already exists");
            } elseif ($unit->pluralName === $newUnit->pluralName) {
                throw new InvalidArgumentException("Unit plural name $newUnit->pluralName already exists");
            } elseif ($unit->acronym === $newUnit->acronym) {
                throw new InvalidArgumentException("Unit acronym $newUnit->acronym already exists");
            } elseif ($unit->symbol === $newUnit->symbol) {
                throw new InvalidArgumentException("Unit symbol $newUnit->symbol already exists");
            }
        }
    }

    abstract protected static function buildDefaultUnits(): void;

    final public static function getById(int $id): static
    {
        static::buildDefaultUnits();
        $staticUnits = self::$units[static::class];
        foreach ($staticUnits as $unit) {
            if ($unit->id === $id) {
                return $unit;
            }
        }
        throw new InvalidArgumentException("Unit ID $id does not exist");
    }

    final public static function getByAcronym(string $acronym): static
    {
        static::buildDefaultUnits();
        $acronym     = trim($acronym);
        $staticUnits = self::$units[static::class];
        foreach ($staticUnits as $unit) {
            if ($unit->acronym === $acronym) {
                return $unit;
            }
        }
        throw new InvalidArgumentException("Unit acronym $acronym does not exist");
    }

    final public static function getBySymbol(string $symbol): static
    {
        static::buildDefaultUnits();
        $symbol      = trim($symbol);
        $staticUnits = self::$units[static::class];
        foreach ($staticUnits as $unit) {
            if ($unit->symbol === $symbol) {
                return $unit;
            }
        }
        throw new InvalidArgumentException("Unit symbol $symbol does not exist");
    }
}
