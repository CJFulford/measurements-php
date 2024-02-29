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

        // now without the second instance
        $length = new Length(1, LengthUnit::METRE);
        $length->add(1, LengthUnit::METRE);
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));
    }

    public function testSubtraction(): void
    {
        $length = new Length(5, LengthUnit::METRE);
        $length->sub(new Length(3, LengthUnit::METRE));
        $this->assertEquals(2, $length->getValue(LengthUnit::METRE));

        // now without the second instance
        $length = new Length(5, LengthUnit::METRE);
        $length->sub(3, LengthUnit::METRE);
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

        // now without the second instance
        $length = new Length(3, LengthUnit::METRE);
        $area   = $length->mulByLength(3, LengthUnit::METRE);
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

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->divByLength(5, LengthUnit::METRE);
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

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->modulo(3, LengthUnit::METRE);
        $this->assertEquals(1, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->modulo(300, LengthUnit::CENTIMETRE);
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

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(3, LengthUnit::METRE);
        $this->assertEquals(3, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(300, LengthUnit::CENTIMETRE);
        $this->assertEquals(3, $length->getValue(LengthUnit::METRE));

        // now test, but the min isn't applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(30, LengthUnit::METRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->min(3000, LengthUnit::CENTIMETRE);
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

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(3, LengthUnit::METRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(300, LengthUnit::CENTIMETRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE));

        // now test, but the max isn't applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(30, LengthUnit::METRE);
        $this->assertEquals(30, $length->getValue(LengthUnit::METRE));

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->max(3000, LengthUnit::CENTIMETRE);
        $this->assertEquals(3000, $length->getValue(LengthUnit::CENTIMETRE));
    }

    public function testClamp(): void
    {
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(3, LengthUnit::METRE), new Length(5, LengthUnit::METRE));
        $this->assertEquals(5, $length->getValue(LengthUnit::METRE), 1);

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(300, LengthUnit::CENTIMETRE), new Length(500, LengthUnit::CENTIMETRE));
        $this->assertEquals(500, $length->getValue(LengthUnit::CENTIMETRE), 2);

        // now test for the min side of the clamp
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(30, LengthUnit::METRE), new Length(50, LengthUnit::METRE));
        $this->assertEquals(30, $length->getValue(LengthUnit::METRE), 3);

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(3000, LengthUnit::CENTIMETRE), new Length(5000, LengthUnit::CENTIMETRE));
        $this->assertEquals(3000, $length->getValue(LengthUnit::CENTIMETRE), 4);

        // now test where the clamp is not applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(5, LengthUnit::METRE), new Length(15, LengthUnit::METRE));
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE), 5);

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(new Length(500, LengthUnit::CENTIMETRE), new Length(1500, LengthUnit::CENTIMETRE));
        $this->assertEquals(1000, $length->getValue(LengthUnit::CENTIMETRE), 6);

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(3, 5, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(5, $length->getValue(LengthUnit::METRE), 7);

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(300, 500, LengthUnit::CENTIMETRE, LengthUnit::CENTIMETRE);
        $this->assertEquals(500, $length->getValue(LengthUnit::CENTIMETRE), 8);

        // now test for the min side of the clamp
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(30, 50, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(30, $length->getValue(LengthUnit::METRE), 9);

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(3000, 5000, LengthUnit::CENTIMETRE, LengthUnit::CENTIMETRE);
        $this->assertEquals(3000, $length->getValue(LengthUnit::CENTIMETRE), 10);

        // now test where the clamp is not applied
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(5, 15, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(10, $length->getValue(LengthUnit::METRE), 11);

        // again with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $length = $length->clamp(500, 1500, LengthUnit::CENTIMETRE, LengthUnit::CENTIMETRE);
        $this->assertEquals(1000, $length->getValue(LengthUnit::CENTIMETRE), 12);
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

        // now without the second instance
        $length = new Length(10, LengthUnit::METRE);
        $this->assertTrue($length->isEqualTo(10, LengthUnit::METRE));
        $this->assertFalse($length->isEqualTo(5, LengthUnit::METRE));

        // now test with a different unit
        $length = new Length(10, LengthUnit::METRE);
        $this->assertTrue($length->isEqualTo(1000, LengthUnit::CENTIMETRE));
        $this->assertFalse($length->isEqualTo(500, LengthUnit::CENTIMETRE));
    }

    public function testIsLessThan(): void
    {
        $length1 = new Length(5, LengthUnit::METRE);
        $length2 = new Length(5, LengthUnit::METRE);
        $length3 = new Length(10, LengthUnit::METRE);

        $this->assertFalse($length1->isLessThan($length2));
        $this->assertTrue($length1->isLessThan($length3));
        $this->assertFalse($length1->isLessThan(5, LengthUnit::METRE));
        $this->assertTrue($length1->isLessThan(10, LengthUnit::METRE));

        $this->assertFalse($length2->isLessThan($length1));
        $this->assertFalse($length3->isLessThan($length1));
        $this->assertFalse($length2->isLessThan(5, LengthUnit::METRE));
        $this->assertFalse($length3->isLessThan(5, LengthUnit::METRE));
    }

    public function testIsLessThanOrEqualTo(): void
    {
        $length1 = new Length(5, LengthUnit::METRE);
        $length2 = new Length(5, LengthUnit::METRE);
        $length3 = new Length(10, LengthUnit::METRE);

        $this->assertTrue($length1->isLessThanOrEqualTo($length2));
        $this->assertTrue($length1->isLessThanOrEqualTo($length3));
        $this->assertTrue($length1->isLessThanOrEqualTo(5, LengthUnit::METRE));
        $this->assertTrue($length1->isLessThanOrEqualTo(10, LengthUnit::METRE));

        $this->assertTrue($length2->isLessThanOrEqualTo($length1));
        $this->assertFalse($length3->isLessThanOrEqualTo($length1));
        $this->assertTrue($length2->isLessThanOrEqualTo(5, LengthUnit::METRE));
        $this->assertFalse($length3->isLessThanOrEqualTo(5, LengthUnit::METRE));
    }

    public function testIsGreaterThan(): void
    {
        $length1 = new Length(10, LengthUnit::METRE);
        $length2 = new Length(10, LengthUnit::METRE);
        $length3 = new Length(5, LengthUnit::METRE);

        $this->assertFalse($length1->isGreaterThan($length2));
        $this->assertTrue($length1->isGreaterThan($length3));
        $this->assertFalse($length1->isGreaterThan(10, LengthUnit::METRE));
        $this->assertTrue($length1->isGreaterThan(5, LengthUnit::METRE));

        $this->assertFalse($length2->isGreaterThan($length1));
        $this->assertFalse($length3->isGreaterThan($length1));
        $this->assertFalse($length2->isGreaterThan(10, LengthUnit::METRE));
        $this->assertFalse($length3->isGreaterThan(10, LengthUnit::METRE));
    }

    public function testIsGreaterThanOrEqualTo(): void
    {
        $length1 = new Length(10, LengthUnit::METRE);
        $length2 = new Length(10, LengthUnit::METRE);
        $length3 = new Length(5, LengthUnit::METRE);

        $this->assertTrue($length1->isGreaterThanOrEqualTo($length2), 1);
        $this->assertTrue($length1->isGreaterThanOrEqualTo($length3), 2);
        $this->assertTrue($length1->isGreaterThanOrEqualTo(10, LengthUnit::METRE), 3);
        $this->assertTrue($length1->isGreaterThanOrEqualTo(5, LengthUnit::METRE), 4);

        $this->assertTrue($length2->isGreaterThanOrEqualTo($length1), 5);
        $this->assertFalse($length3->isGreaterThanOrEqualTo($length1), 6);
        $this->assertTrue($length2->isGreaterThanOrEqualTo(10, LengthUnit::METRE), 7);
        $this->assertFalse($length3->isGreaterThanOrEqualTo(10, LengthUnit::METRE), 8);
    }
}
