<?php

namespace Volume;

use Cjfulford\Measurements\Area;
use Cjfulford\Measurements\AreaUnit;
use Cjfulford\Measurements\Length;
use Cjfulford\Measurements\LengthUnit;
use Cjfulford\Measurements\VolumeImmutable;
use Cjfulford\Measurements\VolumeUnit;
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

    public function testDivisionByLength(): void
    {
        $volume = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $length = new Length(5, LengthUnit::METRE);
        $area = $volume->divByLength($length);
        $this->assertEquals(10, $volume->cubeMetres());
        $this->assertEquals(2, $area->squareMetres());

        // now without a second instance
        $volume2 = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $area2 = $volume2->divByLength(5, LengthUnit::METRE);
        $this->assertEquals(10, $volume2->cubeMetres());
        $this->assertEquals(2, $area2->squareMetres());
    }

    public function testDivisionByArea(): void
    {
        $volume = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $area = new Area(5, AreaUnit::SQUARE_METRE);
        $length = $volume->divByArea($area);
        $this->assertEquals(2, $length->metres());

        // now without a second instance
        $volume = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $length = $volume->divByArea(5, AreaUnit::SQUARE_METRE);
        $this->assertEquals(2, $length->metres());
    }

    public function testDivisionByVolume(): void
    {
        $volume = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $volume->divByVolume(new VolumeImmutable(5, VolumeUnit::CUBE_METRE)));

        // now without a second instance
        $volume = new VolumeImmutable(10, VolumeUnit::CUBE_METRE);
        $this->assertEquals(2, $volume->divByVolume(5, VolumeUnit::CUBE_METRE));
    }
}
