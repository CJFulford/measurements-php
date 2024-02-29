<?php

use Cjfulford\Measurements\LengthImmutable;
use Cjfulford\Measurements\LengthUnit;
use PHPUnit\Framework\TestCase;

/*
 * The LengthImmutable class is a sister class to the Length class.
 * Therefore we only need to test the differences between the two classes.
 */

final class LengthImmutableTest extends TestCase
{
    public function testAddition(): void
    {
        $length1 = new LengthImmutable(1, LengthUnit::METRE);
        $length2 = $length1->add(new LengthImmutable(1, LengthUnit::METRE));
        $this->assertEquals(1, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(2, $length2->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(1, LengthUnit::METRE);
        $length2 = $length1->add(1, LengthUnit::METRE);
        $this->assertEquals(1, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(2, $length2->getValue(LengthUnit::METRE));
    }

    public function testSubtraction(): void
    {
        $length1 = new LengthImmutable(5, LengthUnit::METRE);
        $length2 = $length1->sub(new LengthImmutable(3, LengthUnit::METRE));
        $this->assertEquals(5, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(2, $length2->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(5, LengthUnit::METRE);
        $length2 = $length1->sub(3, LengthUnit::METRE);
        $this->assertEquals(5, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(2, $length2->getValue(LengthUnit::METRE));
    }

    public function testMultiplicationByNumber(): void
    {
        $length1 = new LengthImmutable(3, LengthUnit::METRE);
        $length2 = $length1->mulByNumber(3);
        $this->assertEquals(3, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(9, $length2->getValue(LengthUnit::METRE));
    }

    public function testDivisionByNumber(): void
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->divByNumber(5);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(2, $length2->getValue(LengthUnit::METRE));
    }

    public function testCeil(): void
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->ceil(LengthUnit::KILOMETRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(1000, $length2->getValue(LengthUnit::METRE));
    }

    public function testFloor(): void
    {
        $length1 = new LengthImmutable(750, LengthUnit::CENTIMETRE);
        $length2 = $length1->floor(LengthUnit::METRE);
        $this->assertEquals(7.5, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(7, $length2->getValue(LengthUnit::METRE));
    }

    public function testRound(): void
    {
        $length1 = new LengthImmutable(755, LengthUnit::CENTIMETRE);
        $length2 = $length1->round(LengthUnit::METRE);
        $this->assertEquals(7.55, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(8, $length2->getValue(LengthUnit::METRE));

        $length3 = new LengthImmutable(745, LengthUnit::CENTIMETRE);
        $length4 = $length3->round(LengthUnit::METRE);
        $this->assertEquals(7.45, $length3->getValue(LengthUnit::METRE));
        $this->assertEquals(7, $length4->getValue(LengthUnit::METRE));
    }

    public function testModulo(): void
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->modulo(new LengthImmutable(3, LengthUnit::METRE));
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(1, $length2->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->modulo(3, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(1, $length2->getValue(LengthUnit::METRE));
    }

    public function testMin(): void
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->min(new LengthImmutable(3, LengthUnit::METRE));
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(3, $length2->getValue(LengthUnit::METRE));

        $length3 = new LengthImmutable(3, LengthUnit::METRE);
        $length4 = $length3->min(new LengthImmutable(10, LengthUnit::METRE));
        $this->assertEquals(3, $length3->getValue(LengthUnit::METRE));
        $this->assertEquals(3, $length4->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->min(3, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(3, $length2->getValue(LengthUnit::METRE));

        $length3 = new LengthImmutable(3, LengthUnit::METRE);
        $length4 = $length3->min(10, LengthUnit::METRE);
        $this->assertEquals(3, $length3->getValue(LengthUnit::METRE));
        $this->assertEquals(3, $length4->getValue(LengthUnit::METRE));
    }

    public function testMax(): void
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->max(new LengthImmutable(3, LengthUnit::METRE));
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length2->getValue(LengthUnit::METRE));

        $length3 = new LengthImmutable(3, LengthUnit::METRE);
        $length4 = $length3->max(new LengthImmutable(10, LengthUnit::METRE));
        $this->assertEquals(3, $length3->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length4->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->max(3, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length2->getValue(LengthUnit::METRE));

        $length3 = new LengthImmutable(3, LengthUnit::METRE);
        $length4 = $length3->max(10, LengthUnit::METRE);
        $this->assertEquals(3, $length3->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length4->getValue(LengthUnit::METRE));
    }

    public function testClamp()
    {
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(
            new LengthImmutable(3, LengthUnit::METRE),
            new LengthImmutable(5, LengthUnit::METRE)
        );
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(5, $length2->getValue(LengthUnit::METRE));

        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(
            new LengthImmutable(30, LengthUnit::METRE),
            new LengthImmutable(50, LengthUnit::METRE)
        );
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(30, $length2->getValue(LengthUnit::METRE));

        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(
            new LengthImmutable(3, LengthUnit::METRE),
            new LengthImmutable(50, LengthUnit::METRE)
        );
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length2->getValue(LengthUnit::METRE));

        // now without the second instance
        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(3, 5, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(5, $length2->getValue(LengthUnit::METRE));

        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(30, 50, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(30, $length2->getValue(LengthUnit::METRE));

        $length1 = new LengthImmutable(10, LengthUnit::METRE);
        $length2 = $length1->clamp(3, 50, LengthUnit::METRE, LengthUnit::METRE);
        $this->assertEquals(10, $length1->getValue(LengthUnit::METRE));
        $this->assertEquals(10, $length2->getValue(LengthUnit::METRE));
    }
}
