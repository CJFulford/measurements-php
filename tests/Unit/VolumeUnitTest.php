<?php

namespace Unit;

use Cjfulford\Measurements\Unit\LengthUnit;
use Cjfulford\Measurements\Unit\VolumeUnit;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class VolumeUnitTest extends TestCase
{
    public function testCanGetAllDefaultUnits(): void
    {
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_METRE));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_KILOMETRE));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_CENTIMETRE));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_MILLIMETRE));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_INCH));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_FOOT));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_YARD));
        $this->assertInstanceOf(VolumeUnit::class, VolumeUnit::getById(VolumeUnit::CUBE_MILE));
    }

    public function testMultipleCallsReturnSameInstance(): void
    {
        $this->assertSame(
            VolumeUnit::getById(VolumeUnit::CUBE_METRE),
            VolumeUnit::getById(VolumeUnit::CUBE_METRE)
        );
        $this->assertSame(
            VolumeUnit::getById(VolumeUnit::CUBE_MILE),
            VolumeUnit::getById(VolumeUnit::CUBE_MILE)
        );
    }

    public function testGetByAcronym(): void
    {
        $first = VolumeUnit::getById(VolumeUnit::CUBE_INCH);
        $this->assertSame(
            $first,
            VolumeUnit::getByAcronym($first->acronym)
        );
    }

    public function testGetBySymbol(): void
    {
        $first = VolumeUnit::getById(VolumeUnit::CUBE_YARD);
        $this->assertSame(
            $first,
            VolumeUnit::getBySymbol($first->symbol)
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

        $unit1 = new VolumeUnit(
            id: 20,
            name: 'test1',
            pluralName: 'test1s',
            acronym: 't1',
            correspondingLengthUnitId: $lengthUnit1->id
        );
        $this->assertSame($unit1, VolumeUnit::getById(20));
        $this->assertSame($unit1, VolumeUnit::getByAcronym('t1'));
        $this->assertSame($unit1, VolumeUnit::getBySymbol('t1'));

        $unit2 = new VolumeUnit(
            id: 21,
            name: 'test2',
            pluralName: 'test2s',
            acronym: 't2',
            correspondingLengthUnitId: $lengthUnit2->id
        );
        $this->assertSame($unit2, VolumeUnit::getById(21));
        $this->assertSame($unit2, VolumeUnit::getByAcronym('t2'));
        $this->assertSame($unit2, VolumeUnit::getBySymbol('t2'));

        // test that adding a duplicate in any way fails
        $this->expectException(InvalidArgumentException::class);
        new VolumeUnit(
            id: 20,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new VolumeUnit(
            id: 23,
            name: 'test1',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new VolumeUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test1s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new VolumeUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't1',
            correspondingLengthUnitId: $lengthUnit3->id
        );
        $this->expectException(InvalidArgumentException::class);
        new VolumeUnit(
            id: 23,
            name: 'test3',
            pluralName: 'test3s',
            acronym: 't3',
            correspondingLengthUnitId: $lengthUnit1->id
        );
    }
}
