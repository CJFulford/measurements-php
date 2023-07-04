<?php

namespace Cjfulford\Measurements;

use Exception;

abstract class Unit
{
    private int    $id;
    private float  $baseUnitsPer;
    private string $name;
    private string $pluralName;
    private string $symbol;
    private string $acronym;

    final protected const DEF_BASE_UNITS_PER = 'baseUnitsPer';
    final protected const DEF_NAME           = 'name';
    final protected const DEF_PLURAL_NAME    = 'pluralName';
    final protected const DEF_SYMBOL         = 'symbol';
    final protected const DEF_ACRONYM        = 'acronym';

    final public function __construct(int $id)
    {
        $this->id = $id;

        $definitions = static::getUnitDefinitions();

        if (!isset($definitions[$id])) {
            throw new Exception('No definition for unit');
        }

        $definition = $definitions[$id];

        $this->baseUnitsPer = $definition[self::DEF_BASE_UNITS_PER];
        $this->name         = $definition[self::DEF_NAME];
        $this->pluralName   = $definition[self::DEF_PLURAL_NAME] ?? $this->name . 's';
        $this->symbol       = $definition[self::DEF_SYMBOL] ?? '';
        $this->acronym      = $definition[self::DEF_ACRONYM] ?? '';
    }

    abstract protected static function getUnitDefinitions(): array;

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

    final public function getSymbol(): string
    {
        return $this->symbol;
    }

    final public function getAcronym(): string
    {
        return $this->acronym;
    }
}
