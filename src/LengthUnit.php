<?php

namespace Cjfulford\Measurements;

class LengthUnit extends Unit
{
    public function __construct(int $id)
    {
        parent::__construct(
            id               : $id,
            baseUnitsPerPower: 1,
            namePrefix       : '',
            acronymPostfix   : ''
        );
    }

    public function getCorrespondingAreaUnit() : AreaUnit
    {
        return new AreaUnit($this->getId());
    }
}
