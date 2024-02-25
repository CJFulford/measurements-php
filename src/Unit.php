<?php

namespace Cjfulford\Measurements;

abstract readonly class Unit
{
    protected function __construct(
        public int    $id,
        public int    $baseUnitsPer,
        public string $name,
        public string $pluralName,
        public string $acronym,
        public string $symbol,
    ) {
    }
}
