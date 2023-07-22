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

    public function testBinStr(): void {
        $binary = new Binary(Resolution::Medium);

        $this->assertEquals(
            '000010011000111101101011110011010100011000100001110100110111001111001010',
            $binary->getBinStr(
                $binary->getBytes('test'),
            ),
        );
    }

    public function testPixels(): void {
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
}
