<?php

namespace AdventOfCode\Season2016\Days\Day7;

use PHPUnit\Framework\TestCase;

class PuzzleTest extends TestCase
{

    public function testIsStringContainAbba()
    {
        $puzzle = new Puzzle();
        $this->assertTrue($puzzle->isStringSupportTLS('abba[mnop]qrst'));
        $this->assertTrue($puzzle->isStringSupportTLS('ioxxoj[asdfgh]zxcvbn'));
        $this->assertFalse($puzzle->isStringSupportTLS('abcd[bddb]xyyx'));
        $this->assertFalse($puzzle->isStringSupportTLS('aaaa[qwer]tyui'));
    }
}
