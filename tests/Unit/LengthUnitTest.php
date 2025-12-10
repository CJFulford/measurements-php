<?php

namespace Unit;

use Cjfulford\Measurements\Unit\LengthUnit;
use InvalidArgumentException;
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

    public function testCustomUnitCreation(): void
    {
        $unit1 = new LengthUnit(
            id: 23,
            baseUnitsPer: 43,
            name: 'test4',
            pluralName: 'test4s',
            acronym: 't4',
            symbol: '!'
        );
        $this->assertSame($unit1, LengthUnit::getById(23));
        $this->assertSame($unit1, LengthUnit::getByAcronym('t4'));
        $this->assertSame($unit1, LengthUnit::getBySymbol('!'));

        $unit2 = new LengthUnit(
            id: 24,
            baseUnitsPer: 44,
            name: 'test5',
            pluralName: 'test5s',
            acronym: 't5',
            symbol: '@'
        );
        $this->assertSame($unit2, LengthUnit::getById(24));
        $this->assertSame($unit2, LengthUnit::getByAcronym('t5'));
        $this->assertSame($unit2, LengthUnit::getBySymbol('@'));

        // test that adding a duplicate in any way fails
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 20,
            baseUnitsPer: 21,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            symbol: 't3'
        );
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 21,
            baseUnitsPer: 20,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            symbol: 't3'
        );
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 21,
            baseUnitsPer: 21,
            name: 'test1',
            pluralName: 'test3s',
            acronym: 't3',
            symbol: 't3'
        );
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 21,
            baseUnitsPer: 21,
            name: 'test3',
            pluralName: 'test1s',
            acronym: 't3',
            symbol: 't3'
        );
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 21,
            baseUnitsPer: 21,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't1',
            symbol: 't3'
        );
        $this->expectException(InvalidArgumentException::class);
        new LengthUnit(
            id: 21,
            baseUnitsPer: 21,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            symbol: 't1'
        );
    }
}
