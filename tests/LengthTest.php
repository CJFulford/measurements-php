<?php

use Cjfulford\Measurements\AreaUnit;
use Cjfulford\Measurements\Length;
use Cjfulford\Measurements\LengthUnit;
use PHPUnit\Framework\TestCase;

final class LengthTest extends TestCase
{
    public function testCreation(): void
    {
        $this->assertInstanceOf(Length::class, new Length(1, LengthUnit::METRE));
        $this->assertInstanceOf(Length::class, new Length(1, LengthUnit::getById(LengthUnit::METRE)));
    }

    public function testGetValue(): void
    {
        $length = new Length(1, LengthUnit::KILOMETRE);
        $this->assertEquals(1, $length->getValue(LengthUnit::KILOMETRE));
        $this->assertEquals(1000, $length->getValue(LengthUnit::METRE));
    }

    public function testAddition(): void
    {
        $length = new Length(1, LengthUnit::METRE);
        $length->add(new Length(1, LengthUnit::METRE));
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testSubtraction(): void
    {
        $length = new Length(5, LengthUnit::METRE);
        $length->sub(new Length(3, LengthUnit::METRE));
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testMultiplicationByNumber(): void
    {
        $length = new Length(3, LengthUnit::METRE);
        $length->mulByNumber(3);
        $this->assertEquals(9, $length->getValue(LengthUnit::METRE));
    }

    public function testMultiplicationByLength(): void
    {
        $length = new Length(3, LengthUnit::METRE);
        $area   = $length->mulByLength(new Length(3, LengthUnit::METRE));
        $this->assertEquals(9, $area->getValue(AreaUnit::SQUARE_METRE));
    }

    public function testDivisionByNumber(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length->divByNumber(5);
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testDivisionByLength(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->divByLength(new Length(5, LengthUnit::METRE));
        $this->assertEquals(2, $length);
    }

    public function testCeil(): void
    {
        $length = new Length(10.5, LengthUnit::METRE);
        $length = $length->ceil(LengthUnit::METRE);
        $this->assertEquals(11, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10.5, LengthUnit::METRE);
        $length = $length->ceil(LengthUnit::KILOMETRE);
        $this->assertEquals(1, $length->getValue(LengthUnit::KILOMETRE));
    }

    public function testFloor(): void
    {
        $length = new Length(10.5, LengthUnit::METRE);
        $length = $length->floor(LengthUnit::METRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(250, LengthUnit::CENTIMETRE);
        $length = $length->floor(LengthUnit::METRE);
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testRound(): void
    {
        // rounding up
        $length = new Length(10.6, LengthUnit::METRE);
        $length = $length->round(LengthUnit::METRE);
        $this->assertEquals(11, $length->getValue(LengthUnit::METRE));

        // rounding down
        $length = new Length(10.4, LengthUnit::METRE);
        $length = $length->round(LengthUnit::METRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        // rounding up
        $length = new Length(255, LengthUnit::CENTIMETRE);
        $length = $length->round(LengthUnit::METRE);
        $this->assertEquals(3, $length->getValue(LengthUnit::METRE));

        // rounding down
        $length = new Length(245, LengthUnit::CENTIMETRE);
        $length = $length->round(LengthUnit::METRE);
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testModulo(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->modulo(new Length(3, LengthUnit::METRE));
        $this->assertEquals(1, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->modulo(new Length(300, LengthUnit::CENTIMETRE));
        $this->assertEquals(100, $length->getValue(LengthUnit::CENTIMETRE));
    }

    public function testMin(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(new Length(3, LengthUnit::METRE));
        $this->assertEquals(3, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(new Length(300, LengthUnit::CENTIMETRE));
        $this->assertEquals(3, $length->getValue(LengthUnit::METRE));

        // now test, but the min isn't applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(new Length(30, LengthUnit::METRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(new Length(3000, LengthUnit::CENTIMETRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));
    }

    public function testMax(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(new Length(3, LengthUnit::METRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(new Length(300, LengthUnit::CENTIMETRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // now test, but the max isn't applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(new Length(30, LengthUnit::METRE));
        $this->assertEquals(30, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(new Length(3000, LengthUnit::CENTIMETRE));
        $this->assertEquals(3000, $length->getValue(LengthUnit::CENTIMETRE));
    }

    public function testClamp(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(3, LengthUnit::METRE), new Length(5, LengthUnit::METRE));
        $this->assertEquals(5, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(300, LengthUnit::CENTIMETRE), new Length(500, LengthUnit::CENTIMETRE));
        $this->assertEquals(500, $length->getValue(LengthUnit::CENTIMETRE));

        // now test for the min side of the clamp
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(30, LengthUnit::METRE), new Length(50, LengthUnit::METRE));
        $this->assertEquals(30, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(3000, LengthUnit::CENTIMETRE), new Length(5000, LengthUnit::CENTIMETRE));
        $this->assertEquals(3000, $length->getValue(LengthUnit::CENTIMETRE));

        // now test where the clamp is not applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(5, LengthUnit::METRE), new Length(15, LengthUnit::METRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(500, LengthUnit::CENTIMETRE), new Length(1500, LengthUnit::CENTIMETRE));
        $this->assertEquals(1000, $length->getValue(LengthUnit::CENTIMETRE));
    }

    public function testIsEqualTo(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $this->assertTrue($length->isEqualTo(new Length(10, LengthUnit::METRE)));
        $this->assertFalse($length->isEqualTo(new Length(5, LengthUnit::METRE)));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $this->assertTrue($length->isEqualTo(new Length(1000, LengthUnit::CENTIMETRE)));
        $this->assertFalse($length->isEqualTo(new Length(500, LengthUnit::CENTIMETRE)));
    }

    public function testIsLessThan(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $this->assertFalse($length->isLessThan(new Length(10, LengthUnit::METRE), orEqualTo: false));
        $this->asserttrue($length->isLessThan(new Length(10, LengthUnit::METRE), orEqualTo: true));
        $this->assertFalse($length->isLessThan(new Length(5, LengthUnit::METRE), orEqualTo: false));
        $this->assertFalse($length->isLessThan(new Length(5, LengthUnit::METRE), orEqualTo: true));
        $this->assertTrue($length->isLessThan(new Length(15, LengthUnit::METRE), orEqualTo: false));
        $this->assertTrue($length->isLessThan(new Length(15, LengthUnit::METRE), orEqualTo: true));
    }

    public function testIsGreaterThan(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $this->assertFalse($length->isGreaterThan(new Length(10, LengthUnit::METRE), orEqualTo: false));
        $this->asserttrue($length->isGreaterThan(new Length(10, LengthUnit::METRE), orEqualTo: true));
        $this->assertTrue($length->isGreaterThan(new Length(5, LengthUnit::METRE), orEqualTo: false));
        $this->assertTrue($length->isGreaterThan(new Length(5, LengthUnit::METRE), orEqualTo: true));
        $this->assertFalse($length->isGreaterThan(new Length(15, LengthUnit::METRE), orEqualTo: false));
        $this->assertFalse($length->isGreaterThan(new Length(15, LengthUnit::METRE), orEqualTo: true));
    }
}
