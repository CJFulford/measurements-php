<?php

namespace Volume;

use Cjfulford\Measurements\Area\Area;
use Cjfulford\Measurements\Length\Length;
use Cjfulford\Measurements\Unit\AreaUnit;
use Cjfulford\Measurements\Unit\LengthUnit;
use Cjfulford\Measurements\Unit\VolumeUnit;
use Cjfulford\Measurements\Volume\Volume;
use PHPUnit\Framework\TestCase;

final class VolumeTest extends TestCase
{
    public function testCreation(): void
    {
        $this->assertInstanceOf(Volume::class, new Volume(1, VolumeUnit::CUBE_METRE));
        $this->assertInstanceOf(Volume::class, new Volume(1, VolumeUnit::getById(VolumeUnit::CUBE_METRE)));
    }

    public function testGetValue(): void
    {
        $v = new Volume(1, VolumeUnit::CUBE_KILOMETRE);
        $this->assertEquals(1, $v->cubeKilometres());
        $this->assertEquals(1000000000, $v->cubeMetres());
    }

    public function testAddition(): void
    {
        $v = new Volume(1, VolumeUnit::CUBE_METRE);
        $v->add(new Volume(1, VolumeUnit::CUBE_METRE));
        $this->assertEquals(2, $v->cubeMetres());

        // now without a second instance
        $v = new Volume(1, VolumeUnit::CUBE_METRE);
        $v->add(1, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $v->cubeMetres());
    }

    public function testSubtraction(): void
    {
        $v = new Volume(5, VolumeUnit::CUBE_METRE);
        $v->sub(new Volume(3, VolumeUnit::CUBE_METRE));
        $this->assertEquals(2, $v->cubeMetres());

        // now without a second instance
        $v = new Volume(5, VolumeUnit::CUBE_METRE);
        $v->sub(3, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $v->cubeMetres());
    }

    public function testMultiplication(): void
    {
        $v = new Volume(3, VolumeUnit::CUBE_METRE);
        $v->mulByNumber(3);
        $this->assertEquals(9, $v->cubeMetres());
    }

    public function testDivisionByNumber(): void
    {
        $v = new Volume(10, VolumeUnit::CUBE_METRE);
        $v->divByNumber(5);
        $this->assertEquals(2, $v->cubeMetres());
    }

    public function testDivisionByLength(): void
    {
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $length = new Length(5, LengthUnit::METRE);
        $area = $volume->divByLength($length);
        $this->assertEquals(2, $area->squareMetres());

        // now without a second instance
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $area = $volume->divByLength(5, LengthUnit::METRE);
        $this->assertEquals(2, $area->squareMetres());
    }

    public function testDivisionByArea(): void
    {
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $area = new Area(5, AreaUnit::SQUARE_METRE);
        $length = $volume->divByArea($area);
        $this->assertEquals(2, $length->metres());

        // now without a second instance
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $length = $volume->divByArea(5, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $length->metres());
    }

    public function testDivisionByVolume(): void
    {
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $volume->divByVolume(new Volume(5, VolumeUnit::CUBE_METRE)));

        // now without a second instance
        $volume = new Volume(10, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $volume->divByVolume(5, VolumeUnit::CUBE_METRE));
    }

    public function testEquality(): void
    {
        $v1 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(1e7, VolumeUnit::CUBE_CENTIMETRE);
        $this->assertTrue($v1->isEqualTo($v2));
        $this->assertTrue($v1->isEqualTo($v3));

        $this->assertTrue($v1->isEqualTo(10, VolumeUnit::CUBE_METRE));
        $this->assertTrue($v1->isEqualTo(1e7, VolumeUnit::CUBE_CENTIMETRE));
    }

    public function testNotEquality(): void
    {
        $v1 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(100, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(1000000, VolumeUnit::CUBE_CENTIMETRE);
        $this->assertTrue($v1->isNotEqualTo($v2));
        $this->assertTrue($v1->isNotEqualTo($v3));
        $this->assertTrue($v1->isNotEqualTo(100, VolumeUnit::CUBE_METRE));
        $this->assertTrue($v1->isNotEqualTo(1000000, VolumeUnit::CUBE_CENTIMETRE));
    }

    public function testLessThan(): void
    {
        $v1 = new Volume(5, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(5, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(10, VolumeUnit::CUBE_METRE);

        $this->assertFalse($v1->isLessThan($v2));
        $this->assertTrue($v1->isLessThan($v3));
        $this->assertFalse($v1->isLessThan(5, VolumeUnit::CUBE_METRE));
        $this->assertTrue($v1->isLessThan(10, VolumeUnit::CUBE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertFalse($v2->isLessThan($v1));
        $this->assertFalse($v3->isLessThan($v1));
        $this->assertFalse($v2->isLessThan(5, VolumeUnit::CUBE_METRE));
        $this->assertFalse($v3->isLessThan(5, VolumeUnit::CUBE_METRE));
    }

    public function testLessThanOrEqualTo(): void
    {
        $v1 = new Volume(5, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(5, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(10, VolumeUnit::CUBE_METRE);

        $this->assertTrue($v1->isLessThanOrEqualTo($v2));
        $this->assertTrue($v1->isLessThanOrEqualTo($v3));
        $this->assertTrue($v1->isLessThanOrEqualTo(5, VolumeUnit::CUBE_METRE));
        $this->assertTrue($v1->isLessThanOrEqualTo(10, VolumeUnit::CUBE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertTrue($v2->isLessThanOrEqualTo($v1));
        $this->assertFalse($v3->isLessThanOrEqualTo($v1));
        $this->assertTrue($v2->isLessThanOrEqualTo(5, VolumeUnit::CUBE_METRE));
        $this->assertFalse($v3->isLessThanOrEqualTo(5, VolumeUnit::CUBE_METRE));
    }

    public function testGreaterThan(): void
    {
        $v1 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(5, VolumeUnit::CUBE_METRE);

        $this->assertFalse($v1->isGreaterThan($v2));
        $this->assertTrue($v1->isGreaterThan($v3));
        $this->assertFalse($v1->isGreaterThan(10, VolumeUnit::CUBE_METRE));
        $this->assertTrue($v1->isGreaterThan(5, VolumeUnit::CUBE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertFalse($v2->isGreaterThan($v1));
        $this->assertFalse($v3->isGreaterThan($v1));
        $this->assertFalse($v2->isGreaterThan(10, VolumeUnit::CUBE_METRE));
        $this->assertFalse($v3->isGreaterThan(10, VolumeUnit::CUBE_METRE));
    }

    public function testGreaterThanOrEqualTo(): void
    {
        $v1 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v2 = new Volume(10, VolumeUnit::CUBE_METRE);
        $v3 = new Volume(5, VolumeUnit::CUBE_METRE);

        $this->assertTrue($v1->isGreaterThanOrEqualTo($v2), 1);
        $this->assertTrue($v1->isGreaterThanOrEqualTo($v3), 2);
        $this->assertTrue($v1->isGreaterThanOrEqualTo(10, VolumeUnit::CUBE_METRE), 3);
        $this->assertTrue($v1->isGreaterThanOrEqualTo(5, VolumeUnit::CUBE_METRE), 4);

        // now make sure it returns correctly with backwards arguments
        $this->assertTrue($v2->isGreaterThanOrEqualTo($v1), 5);
        $this->assertFalse($v3->isGreaterThanOrEqualTo($v1), 6);
        $this->assertTrue($v2->isGreaterThanOrEqualTo(10, VolumeUnit::CUBE_METRE), 7);
        $this->assertFalse($v3->isGreaterThanOrEqualTo(10, VolumeUnit::CUBE_METRE), 8);
    }

    public function testFormatting(): void
    {
        $v = new Volume(10, VolumeUnit::CUBE_METRE);
        $this->assertEquals('10.00000m³', $v->format(VolumeUnit::CUBE_METRE, 5));
    }

    public function testBasicMultiFormatting(): void
    {
        // basic case
        $length = new Volume(10.5, VolumeUnit::CUBE_FOOT);
        $this->assertEquals("10ft³,864.00in³", $length->multiFormat([VolumeUnit::CUBE_FOOT, VolumeUnit::CUBE_INCH], 2));
    }

    public function testMultiFormattingWhereFirstUnitIsNotNeeded(): void
    {
        // case where the first unit is not needed
        $v = new Volume(1.5, VolumeUnit::CUBE_FOOT);
        $units = [VolumeUnit::CUBE_YARD, VolumeUnit::CUBE_FOOT, VolumeUnit::CUBE_INCH];
        $this->assertEquals("1ft³,864.00in³", $v->multiFormat($units, 2));
    }

    public function testMultiFormattingWhereMiddleUnitIsNotNeeded(): void
    {
        // case where the first unit is not needed
        $v = new Volume(1, VolumeUnit::CUBE_YARD);
        $v = $v->add(1, VolumeUnit::CUBE_INCH);
        $units = [VolumeUnit::CUBE_YARD, VolumeUnit::CUBE_FOOT, VolumeUnit::CUBE_INCH];
        $this->assertEquals("1yd³,1.00in³", $v->multiFormat($units, 2));
    }

    public function testMultiFormattingWithOutOfOrderUnits(): void
    {
        // case where the units are not in order
        $v = new Volume(3, VolumeUnit::CUBE_YARD);
        $v = $v->add(1.5, VolumeUnit::CUBE_FOOT);
        $units = [VolumeUnit::CUBE_INCH, VolumeUnit::CUBE_FOOT, VolumeUnit::CUBE_YARD];
        $this->assertEquals("3yd³,1ft³,864.00in³", $v->multiFormat($units, 2));
    }

    public function testMultiFormattingWithZeroLastUnit(): void
    {
        // case where the last unit is zero
        $v = new Volume(10, VolumeUnit::CUBE_FOOT);
        $units = [VolumeUnit::CUBE_FOOT, VolumeUnit::CUBE_INCH];
        $this->assertEquals("10ft³,0.00in³", $v->multiFormat($units, 2));
    }
}
