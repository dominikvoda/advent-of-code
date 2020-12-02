<?php

namespace AdventOfCode\Season2016\Days\Day9;

use PHPUnit\Framework\TestCase;

class PuzzleTest extends TestCase
{
//    public function testGetMarkerSize()
//    {
//        $puzzle = new Puzzle();
//
//        $this->assertEquals(6, $puzzle->getMarkerSize('ADVENT'));
//        $this->assertEquals(6, $puzzle->getMarkerSize('(1x5)BC'));
////        $this->assertEquals(10, $puzzle->getMarkerSize('(2x2)BCD(2x2)EFG'));
//        $this->assertEquals(9, $puzzle->getMarkerSize('(3x3)XYZ'));
//        $this->assertEquals(6, $puzzle->getMarkerSize('(6x1)(1x3)A'));
//        $this->assertEquals(17, $puzzle->getMarkerSize('(8x2)(3x3)ABCY'));
//    }

    public function testMultipleSubstring()
    {
        $puzzle = new Puzzle();

        $this->assertEquals('abababc', $puzzle->multipleSubstring('abc', 2, 3));
        $this->assertEquals('abcabc', $puzzle->multipleSubstring('abc', 3, 2));
    }


}
