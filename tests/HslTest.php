<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Hsl;

final class HslTest extends TestCase {
    public function testHslBlack(): void {
        $black = new Hsl(0.0, 0.0, 0.0);

        $this->assertEquals(
            [0, 0, 0],
            $black->rgb(),
        );
    }

    public function testHslWhite(): void {
        $white = new Hsl(0.0, 0.0, 100.0);

        $this->assertEquals(
            [255, 255, 255],
            $white->rgb(),
        );
    }

    public function testHslRed(): void {
        $red = new Hsl(0.0, 100.0, 50.0);

        $this->assertEquals(
            [255, 0, 0],
            $red->rgb(),
        );
    }

    public function testHslGreen(): void {
        $green = new Hsl(120.0, 100.0, 50.0);

        $this->assertEquals(
            [0, 255, 0],
            $green->rgb(),
        );
    }

    public function testHslBlue(): void {
        $blue = new Hsl(240.0, 100.0, 50.0);

        $this->assertEquals(
            [0, 0, 255],
            $blue->rgb(),
        );
    }
}
