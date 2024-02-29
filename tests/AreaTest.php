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

        // now without a second instance
        $area = new Area(1, AreaUnit::SQUARE_METRE);
        $area->add(1, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testSubtraction(): void
    {
        $area = new Area(5, AreaUnit::SQUARE_METRE);
        $area->sub(new Area(3, AreaUnit::SQUARE_METRE));
        $this->assertEquals(2, $area->getValue(AreaUnit::SQUARE_METRE));

        // now without a second instance
        $area = new Area(5, AreaUnit::SQUARE_METRE);
        $area->sub(3, AreaUnit::SQUARE_METRE);
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

        // now without a second instance
        $area   = new Area(10, AreaUnit::SQUARE_METRE);
        $length = $area->divByLength(5, Cjfulford\Measurements\LengthUnit::METRE);
        $this->assertEquals(2, $length->getValue(Cjfulford\Measurements\LengthUnit::METRE));
    }

    public function testDivisionByArea(): void
    {
        $area  = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $area->divByArea($area2));

        // now without a second instance
        $area = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $area->divByArea(5, AreaUnit::SQUARE_METRE));
    }

    public function testEquality(): void
    {
        $area1 = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(10, AreaUnit::SQUARE_METRE);
        $area3 = new Area(100000, AreaUnit::SQUARE_CENTIMETRE);
        $this->assertTrue($area1->isEqualTo($area2));
        $this->assertTrue($area1->isEqualTo($area3));
        $this->assertTrue($area1->isEqualTo(10, AreaUnit::SQUARE_METRE));
        $this->assertTrue($area1->isEqualTo(100000, AreaUnit::SQUARE_CENTIMETRE));
    }

    public function testLessThan(): void
    {
        $area1 = new Area(5, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $area3 = new Area(10, AreaUnit::SQUARE_METRE);

        $this->assertFalse($area1->isLessThan($area2));
        $this->assertTrue($area1->isLessThan($area3));
        $this->assertFalse($area1->isLessThan(5, AreaUnit::SQUARE_METRE));
        $this->assertTrue($area1->isLessThan(10, AreaUnit::SQUARE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertFalse($area2->isLessThan($area1));
        $this->assertFalse($area3->isLessThan($area1));
        $this->assertFalse($area2->isLessThan(5, AreaUnit::SQUARE_METRE));
        $this->assertFalse($area3->isLessThan(5, AreaUnit::SQUARE_METRE));
    }

    public function testLessThanOrEqualTo(): void
    {
        $area1 = new Area(5, AreaUnit::SQUARE_METRE);
        $area2 = new Area(5, AreaUnit::SQUARE_METRE);
        $area3 = new Area(10, AreaUnit::SQUARE_METRE);

        $this->assertTrue($area1->isLessThanOrEqualTo($area2));
        $this->assertTrue($area1->isLessThanOrEqualTo($area3));
        $this->assertTrue($area1->isLessThanOrEqualTo(5, AreaUnit::SQUARE_METRE));
        $this->assertTrue($area1->isLessThanOrEqualTo(10, AreaUnit::SQUARE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertTrue($area2->isLessThanOrEqualTo($area1));
        $this->assertFalse($area3->isLessThanOrEqualTo($area1));
        $this->assertTrue($area2->isLessThanOrEqualTo(5, AreaUnit::SQUARE_METRE));
        $this->assertFalse($area3->isLessThanOrEqualTo(5, AreaUnit::SQUARE_METRE));
    }

    public function testGreaterThan(): void
    {
        $area1 = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(10, AreaUnit::SQUARE_METRE);
        $area3 = new Area(5, AreaUnit::SQUARE_METRE);

        $this->assertFalse($area1->isGreaterThan($area2));
        $this->assertTrue($area1->isGreaterThan($area3));
        $this->assertFalse($area1->isGreaterThan(10, AreaUnit::SQUARE_METRE));
        $this->assertTrue($area1->isGreaterThan(5, AreaUnit::SQUARE_METRE));

        // now make sure it returns correctly with backwards arguments
        $this->assertFalse($area2->isGreaterThan($area1));
        $this->assertFalse($area3->isGreaterThan($area1));
        $this->assertFalse($area2->isGreaterThan(10, AreaUnit::SQUARE_METRE));
        $this->assertFalse($area3->isGreaterThan(10, AreaUnit::SQUARE_METRE));
    }

    public function testGreaterThanOrEqualTo(): void
    {
        $area1 = new Area(10, AreaUnit::SQUARE_METRE);
        $area2 = new Area(10, AreaUnit::SQUARE_METRE);
        $area3 = new Area(5, AreaUnit::SQUARE_METRE);

        $this->assertTrue($area1->isGreaterThanOrEqualTo($area2), 1);
        $this->assertTrue($area1->isGreaterThanOrEqualTo($area3), 2);
        $this->assertTrue($area1->isGreaterThanOrEqualTo(10, AreaUnit::SQUARE_METRE), 3);
        $this->assertTrue($area1->isGreaterThanOrEqualTo(5, AreaUnit::SQUARE_METRE), 4);

        // now make sure it returns correctly with backwards arguments
        $this->assertTrue($area2->isGreaterThanOrEqualTo($area1), 5);
        $this->assertFalse($area3->isGreaterThanOrEqualTo($area1), 6);
        $this->assertTrue($area2->isGreaterThanOrEqualTo(10, AreaUnit::SQUARE_METRE), 7);
        $this->assertFalse($area3->isGreaterThanOrEqualTo(10, AreaUnit::SQUARE_METRE), 8);
    }

    public function testFormatting(): void
    {
        $area = new Area(10, AreaUnit::SQUARE_METRE);
        $this->assertEquals('10.00000m²', $area->format(AreaUnit::SQUARE_METRE, 5));
    }
}
