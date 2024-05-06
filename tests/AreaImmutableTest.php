<?php

use Cjfulford\Measurements\AreaImmutable;
use Cjfulford\Measurements\AreaUnit;
use PHPUnit\Framework\TestCase;

/*
 * The AreaImmutable class is a sister class to the Area class.
 * Therefore we only need to test the differences between the two classes.
 */

final class AreaImmutableTest extends TestCase
{
    public function testAddition(): void
    {
        $area1 = new AreaImmutable(1, AreaUnit::SQUARE_METRE);
        $area2 = $area1->add(new AreaImmutable(1, AreaUnit::SQUARE_METRE));
            $this->assertEquals(1, $area1->squareMetres());
        $this->assertEquals(2, $area2->squareMetres());

        // now without a second instance
        $area3 = new AreaImmutable(1, AreaUnit::SQUARE_METRE);
        $area4 = $area1->add(1, AreaUnit::SQUARE_METRE);
        $this->assertEquals(1, $area3->squareMetres());
        $this->assertEquals(2, $area4->squareMetres());
    }

    public function testSubtraction(): void
    {
        $area1 = new AreaImmutable(5, AreaUnit::SQUARE_METRE);
        $area2 = $area1->sub(new AreaImmutable(3, AreaUnit::SQUARE_METRE));
        $this->assertEquals(5, $area1->squareMetres());
        $this->assertEquals(2, $area2->squareMetres());

        // now without a second instance
        $area3 = new AreaImmutable(5, AreaUnit::SQUARE_METRE);
        $area4 = $area1->sub(3, AreaUnit::SQUARE_METRE);
        $this->assertEquals(5, $area3->squareMetres());
        $this->assertEquals(2, $area4->squareMetres());
    }

    public function testMultiplication(): void
    {
        $area1 = new AreaImmutable(3, AreaUnit::SQUARE_METRE);
        $area2 = $area1->mulByNumber(3);
        $this->assertEquals(3, $area1->squareMetres());
        $this->assertEquals(9, $area2->squareMetres());
    }

    public function testDivisionByNumber(): void
    {
        $area1 = new AreaImmutable(10, AreaUnit::SQUARE_METRE);

        $area2 = $area1->divByNumber(5);
        $this->assertEquals(10, $area1->squareMetres());
        $this->assertEquals(2, $area2->squareMetres());
    }

    public function testDivisionByLength(): void
    {
        $area   = new AreaImmutable(10, AreaUnit::SQUARE_METRE);
        $length = new Cjfulford\Measurements\Length(5, Cjfulford\Measurements\LengthUnit::METRE);
        $length = $area->divByLength($length);
        $this->assertEquals(10, $area->squareMetres());
        $this->assertEquals(2, $length->metres());

        // now without a second instance
        $area2   = new AreaImmutable(10, AreaUnit::SQUARE_METRE);
        $length2 = $area2->divByLength(5, Cjfulford\Measurements\LengthUnit::METRE);
        $this->assertEquals(10, $area2->squareMetres());
        $this->assertEquals(2, $length2->metres());
    }
}
