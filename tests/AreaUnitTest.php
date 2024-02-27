<?php

use Cjfulford\Measurements\AreaUnit;
use PHPUnit\Framework\TestCase;

final class AreaUnitTest extends TestCase
{
    public function testCanGetAllDefaultUnits(): void
    {
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_METRE));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_KILOMETRE));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_CENTIMETRE));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_MILLIMETRE));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_INCH));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_FOOT));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_YARD));
        $this->assertInstanceOf(AreaUnit::class, AreaUnit::getById(AreaUnit::SQUARE_MILE));
    }

    public function testMultipleCallsReturnSameInstance(): void
    {
        $this->assertSame(
            AreaUnit::getById(AreaUnit::SQUARE_METRE),
            AreaUnit::getById(AreaUnit::SQUARE_METRE)
        );
        $this->assertSame(
            AreaUnit::getById(AreaUnit::SQUARE_MILE),
            AreaUnit::getById(AreaUnit::SQUARE_MILE)
        );
    }

    public function testGetByAcronym(): void
    {
        $first = AreaUnit::getById(AreaUnit::SQUARE_INCH);
        $this->assertSame(
            $first,
            AreaUnit::getByAcronym($first->acronym)
        );
    }

    public function testGetBySymbol(): void
    {
        $first = AreaUnit::getById(AreaUnit::SQUARE_YARD);
        $this->assertSame(
            $first,
            AreaUnit::getBySymbol($first->symbol)
        );
    }
}
