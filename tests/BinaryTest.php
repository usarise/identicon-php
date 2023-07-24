<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\{Binary, Resolution};

final class BinaryTest extends TestCase {
    public function testBytes(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            [
                1 => 9,
                2 => 143,
                3 => 107,
                4 => 205,
                5 => 70,
                6 => 33,
                7 => 211,
                8 => 115,
                9 => 202,
                10 => 222,
                11 => 78,
                12 => 131,
                13 => 38,
                14 => 39,
                15 => 180,
                16 => 246,
            ],
            $binary->getBytes('test'),
        );
    }

    public function testBinStrDefault(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            '000010011000111101101011110011010100011000100001110100110111001111001010',
            $binary->getBinStr(
                $binary->getBytes('test'),
            ),
        );
    }

    public function testBinStrResolutionTiny(): void {
        $binary = new Binary(Resolution::Tiny);

        $this->assertEquals(
            '01001011010000111011000010101110',
            $binary->getBinStr(
                $binary->getBytes('r'),
            ),
        );
    }

    public function testBinStrResolutionSmall(): void {
        $binary = new Binary(Resolution::Small);

        $this->assertEquals(
            '01001011010000111011000010101110111000110101011000',
            $binary->getBinStr(
                $binary->getBytes('r'),
            ),
        );
    }

    public function testBinStrResolutionMedium(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            '010010110100001110110000101011101110001101010110001001001100110110010101',
            $binary->getBinStr(
                $binary->getBytes('r'),
            ),
        );
    }

    public function testBinStrResolutionLarge(): void {
        $binary = new Binary(Resolution::Large);

        $this->assertEquals(
            '01001011010000111011000010101110111000110101011000100100110011011001010110111001000100000001100010',
            $binary->getBinStr(
                $binary->getBytes('r'),
            ),
        );
    }

    public function testBinStrResolutionHuge(): void {
        $binary = new Binary(Resolution::Huge);

        $this->assertEquals(
            '01001011010000111011000010101110111000110101011000100100110011011001010110111001000100000001100010011011001111011100001000110001',
            $binary->getBinStr(
                $binary->getBytes('r'),
            ),
        );
    }

    public function testPixelsDefault(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 1, 1, 1, 0, 1, 1, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 0],
                [0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0],
                [0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0],
                [0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0],
                [0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0],
                [0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0],
                [0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 0],
                [0, 1, 1, 1, 0, 1, 1, 0, 1, 0, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('test'),
                ),
            ),
        );
    }

    public function testPixelsResolutionTiny(): void {
        $binary = new Binary(Resolution::Tiny);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [0, 0, 1, 1, 0, 0, 0, 0],
                [0, 0, 1, 0, 1, 1, 1, 0],
                [0, 0, 1, 0, 1, 1, 1, 0],
                [0, 0, 1, 1, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('r'),
                ),
            ),
        );
    }

    public function testPixelsResolutionSmall(): void {
        $binary = new Binary(Resolution::Small);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 1, 1, 1, 0, 1, 0],
                [0, 0, 0, 0, 1, 0, 1, 0, 1, 0],
                [0, 0, 1, 1, 1, 0, 0, 0, 1, 0],
                [0, 1, 0, 1, 0, 1, 1, 0, 0, 0],
                [0, 1, 0, 1, 0, 1, 1, 0, 0, 0],
                [0, 0, 1, 1, 1, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1, 0, 1, 0, 1, 0],
                [0, 0, 0, 0, 1, 1, 1, 0, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('r'),
                ),
            ),
        );
    }

    public function testPixelsResolutionMedium(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0],
                [0, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0],
                [0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0],
                [0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0],
                [0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0],
                [0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0],
                [0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0],
                [0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0],
                [0, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0],
                [0, 0, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('r'),
                ),
            ),
        );
    }

    public function testPixelsResolutionLarge(): void {
        $binary = new Binary(Resolution::Large);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 1, 1, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0],
                [0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0],
                [0, 1, 0, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0],
                [0, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0],
                [0, 1, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0],
                [0, 1, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0],
                [0, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0],
                [0, 1, 0, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0],
                [0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0],
                [0, 1, 1, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('r'),
                ),
            ),
        );
    }

    public function testPixelsResolutionHuge(): void {
        $binary = new Binary(Resolution::Huge);

        $this->assertEquals(
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 1, 1, 1, 0],
                [0, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0],
                [0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0],
                [0, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0],
                [0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0],
                [0, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 0, 0],
                [0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0],
                [0, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 0, 0],
                [0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0],
                [0, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0],
                [0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0],
                [0, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0],
                [0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 1, 1, 1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ],
            $binary->getPixels(
                $binary->getBinStr(
                    $binary->getBytes('r'),
                ),
            ),
        );
    }
}
