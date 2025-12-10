<?php

namespace Volume;

use Cjfulford\Measurements\Unit\VolumeUnit;
use Cjfulford\Measurements\Volume\VolumeImmutable;
use PHPUnit\Framework\TestCase;

/*
 * The VolumeImmutable class is a sister class to the Volume class.
 * Therefore we only need to test the differences between the two classes.
 */

final class VolumeImmutableTest extends TestCase
{
    public function testAddition(): void
    {
        $volume1 = new VolumeImmutable(1, VolumeUnit::CUBE_METRE);
        $volume2 = $volume1->add(new VolumeImmutable(1, VolumeUnit::CUBE_METRE));
        $this->assertEquals(1, $volume1->cubeMetres());
        $this->assertEquals(2, $volume2->cubeMetres());

        // now without a second instance
        $volume3 = new VolumeImmutable(1, VolumeUnit::CUBE_METRE);
        $volume4 = $volume1->add(1, VolumeUnit::CUBE_METRE);
        $this->assertEquals(1, $volume3->cubeMetres());
        $this->assertEquals(2, $volume4->cubeMetres());
    }

    public function testSubtraction(): void
    {
        $v1 = new VolumeImmutable(5, VolumeUnit::CUBE_METRE);
        $v2 = $v1->sub(new VolumeImmutable(3, VolumeUnit::CUBE_METRE));
        $this->assertEquals(5, $v1->cubeMetres());
        $this->assertEquals(2, $v2->cubeMetres());

        // now without a second instance
        $v3 = new VolumeImmutable(5, VolumeUnit::CUBE_METRE);
        $v4 = $v1->sub(3, VolumeUnit::CUBE_METRE);
        $this->assertEquals(5, $v3->cubeMetres());
        $this->assertEquals(2, $v4->cubeMetres());
    }

    public function testMultiplication(): void
    {
        $area1 = new VolumeImmutable(3, VolumeUnit::CUBE_METRE);
        $area2 = $area1->mulByNumber(3);
        $this->assertEquals(3, $area1->cubeMetres());
        $this->assertEquals(9, $area2->cubeMetres());
    }

    public function testDivisionByNumber(): void
    {
        $area1 = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);

        $area2 = $area1->divByNumber(5);
        $this->assertEquals(10, $area1->cubeMetres());
        $this->assertEquals(2, $area2->cubeMetres());
    }

//    public function testDivisionByLength(): void
//    {
//        $area = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
//        $length = new Length(5, LengthUnit::METRE);
//        $length = $area->divByLength($length);
//        $this->assertEquals(10, $area->cubeMetres());
//        $this->assertEquals(2, $length->metres());
//
//        // now without a second instance
//        $area2 = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
//        $length2 = $area2->divByLength(5, LengthUnit::METRE);
//        $this->assertEquals(10, $area2->cubeMetres());
//        $this->assertEquals(2, $length2->metres());
//    }
}
