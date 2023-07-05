<?php

namespace Cjfulford\Measurements;

class AreaUnit extends Unit
{

    public function __construct(int $id)
    {
        parent::__construct(
            id               : $id,
            baseUnitsPerPower: 2,
            namePrefix       : 'square',
            acronymPostfix   : '²'
        );
    }
}
