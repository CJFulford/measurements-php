<?php

use Cjfulford\Measurements\Area;
use Cjfulford\Measurements\AreaUnit;
use PHPUnit\Framework\TestCase;

final class AreaTest extends TestCase
{
    public function testCreation(): void
    {
        $this->assertInstanceOf(Area::class, new Area(1, AreaUnit::SQUARE_METRE));
        $this->assertInstanceOf(Area::class, new Area(1, AreaUnit::getById(AreaUnit::SQUARE_METRE)));
    }

    public function testGetValue(): void
    {
        $area = new Area(1, AreaUnit::SQUARE_KILOMETRE);
        $this->assertEquals(1, $area->getValue(AreaUnit::SQUARE_KILOMETRE));
        $this->assertEquals(1000000, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testAddition(): void
    {
        $area = new Area(1, AreaUnit::SQUARE_METRE);
        $area->add(new Area(1, AreaUnit::SQUARE_METRE));
        $this->assertEquals(2, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testSubtraction(): void
    {
        $area = new Area(5, AreaUnit::SQUARE_METRE);
        $area->sub(new Area(3, AreaUnit::SQUARE_METRE));
        $this->assertEquals(2, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testMultiplication(): void
    {
        $area = new Area(3, AreaUnit::SQUARE_METRE);
        $area->mulByNumber(3);
        $this->assertEquals(9, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testDivisionByNumber(): void
    {
        $area = new Area(10, AreaUnit::SQUARE_METRE);
        $area->divByNumber(5);
        $this->assertEquals(2, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testDivisionByLength(): void
    {
        $area   = new Area(10, AreaUnit::SQUARE_METRE);
        $length = new Cjfulford\Measurements\Length(5, Cjfulford\Measurements\LengthUnit::METRE);
        $length = $area->divByLength($length);
        $this->assertEquals(2, $length->getValue(Cjfulford\Measurements\LengthUnit::METRE));
    }

    public function testDivisionByArea(): void
    {
        $area  = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $area->divByArea($area2));
    }

    public function testEquality(): void
    {
        $area  = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertTrue($area->isEqualTo($area2));

        // now with different units
        $area2 = new Area(100000, AreaUnit::SQUARE_CENTIMETRE);
        $this->assertTrue($area->isEqualTo($area2));
    }

    public function testGreaterThan(): void
    {
        $area  = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $area3 = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertTrue($area->isGreaterThan($area2, orEqualTo: false));
        $this->assertFalse($area->isGreaterThan($area3, orEqualTo: false));
        $this->assertTrue($area->isGreaterThan($area2, orEqualTo: true));
        $this->assertTrue($area->isGreaterThan($area3, orEqualTo: true));

        // now make sure it returns the opposite with backwards arguments
        $this->assertFalse($area2->isGreaterThan($area, orEqualTo: false));
        $this->assertFalse($area3->isGreaterThan($area, orEqualTo: false));
        $this->assertFalse($area2->isGreaterThan($area, orEqualTo: true));
        $this->assertTrue($area3->isGreaterThan($area, orEqualTo: true));
    }

    public function testLessThan(): void
    {
        $area  = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $area3 = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertFalse($area->isLessThan($area2, orEqualTo: false));
        $this->assertFalse($area->isLessThan($area3, orEqualTo: false));
        $this->assertFalse($area->isLessThan($area2, orEqualTo: true));
        $this->assertTrue($area->isLessThan($area3, orEqualTo: true));

        // now make sure it returns the opposite with backwards arguments
        $this->assertTrue($area2->isLessThan($area, orEqualTo: false));
        $this->assertFalse($area3->isLessThan($area, orEqualTo: false));
        $this->assertTrue($area2->isLessThan($area, orEqualTo: true));
        $this->assertTrue($area3->isLessThan($area, orEqualTo: true));
    }

    public function testFormatting(): void
    {
        $area = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertEquals('10.00000m²', $area->format(AreaUnit::SQUARE_METRE, 5));
    }
}
