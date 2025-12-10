<?php

namespace Unit;

use Cjfulford\Measurements\Unit\AreaUnit;
use Cjfulford\Measurements\Unit\LengthUnit;
use InvalidArgumentException;
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

    public function testCustomUnitCreation(): void
    {
        $lengthUnit1 = new LengthUnit(
            id: 20,
            baseUnitsPer: 40,
            name: 'test1',
            pluralName: 'test1s',
            acronym: 't1',
            symbol: 't1'
        );
        $lengthUnit2 = new LengthUnit(
            id: 21,
            baseUnitsPer: 41,
            name: 'test2',
            pluralName: 'test2s',
            acronym: 't2',
            symbol: 't2'
        );
        $lengthUnit3 = new LengthUnit(
            id: 22,
            baseUnitsPer: 42,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            symbol: 't3'
        );

        $unit1 = new AreaUnit(
            id: 20,
            name: 'test1',
            pluralName: 'test1s',
            acronym: 't1',
            correspondingLengthUnitId: $lengthUnit1->id
        );
        $this->assertSame($unit1, AreaUnit::getById(20));
        $this->assertSame($unit1, AreaUnit::getByAcronym('t1'));
        $this->assertSame($unit1, AreaUnit::getBySymbol('t1'));

        $unit2 = new AreaUnit(
            id: 21,
            name: 'test2',
            pluralName: 'test2s',
            acronym: 't2',
            correspondingLengthUnitId: $lengthUnit2->id
        );
        $this->assertSame($unit2, AreaUnit::getById(21));
        $this->assertSame($unit2, AreaUnit::getByAcronym('t2'));
        $this->assertSame($unit2, AreaUnit::getBySymbol('t2'));

        // test that adding a duplicate in any way fails
        $this->expectException(InvalidArgumentException::class);
        new AreaUnit(
            id: 20,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new AreaUnit(
            id: 23,
            name: 'test1',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new AreaUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test1s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new AreaUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't1',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new AreaUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit1->id
        );
    }
}
