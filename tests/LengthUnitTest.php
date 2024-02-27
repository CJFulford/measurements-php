<?php

use Cjfulford\Measurements\LengthUnit;
use PHPUnit\Framework\TestCase;

final class LengthUnitTest extends TestCase
{
    public function testCanGetAllDefaultUnits(): void
    {
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::KILOMETRE));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::METRE));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::CENTIMETRE));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::MILLIMETRE));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::INCH));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::FOOT));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::YARD));
        $this->assertInstanceOf(LengthUnit::class, LengthUnit::getById(LengthUnit::MILE));
    }

    public function testMultipleCallsReturnSameInstance(): void
    {
        $this->assertSame(
            LengthUnit::getById(LengthUnit::KILOMETRE),
            LengthUnit::getById(LengthUnit::KILOMETRE)
        );
        $this->assertSame(
            LengthUnit::getById(LengthUnit::MILE),
            LengthUnit::getById(LengthUnit::MILE)
        );
    }

    public function testGetByAcronym(): void
    {
        $first = LengthUnit::getById(LengthUnit::KILOMETRE);
        $this->assertSame(
            $first,
            LengthUnit::getByAcronym($first->acronym)
        );
    }

    public function testGetBySymbol(): void
    {
        $first = LengthUnit::getById(LengthUnit::CENTIMETRE);
        $this->assertSame(
            $first,
            LengthUnit::getBySymbol($first->symbol)
        );
    }
}
