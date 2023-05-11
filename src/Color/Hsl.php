<?php

declare(strict_types=1);

namespace Usarise\Identicon\Color;

// source - https://github.com/dgraham/identicon/blob/v0.2.1/src/hsl.rs
final class Hsl {
    public function __construct(
        private readonly float $hue,
        private readonly float $sat,
        private readonly float $lum,
    ) {
    }

    /**
     * @return non-empty-array<int, int>
     */
    public function rgb(): array {
        $hue = $this->hue / 360.0;
        $sat = $this->sat / 100.0;
        $lum = $this->lum / 100.0;

        $b = match (true) {
            $lum <= 0.5 => $lum * ($sat + 1.0),
            default => $lum + $sat - $lum * $sat,
        };

        $a = $lum * 2.0 - $b;

        $r = $this->hueToRgb($a, $b, $hue + (1.0 / 3.0));
        $g = $this->hueToRgb($a, $b, $hue);
        $b = $this->hueToRgb($a, $b, $hue - (1.0 / 3.0));

        return [$r, $g, $b];
    }

    private function hueToRgb(float $a, float $b, float $hue): int {
        $h = match (true) {
            $hue < 0.0 => $hue += 1.0,
            $hue > 1.0 => $hue -= 1.0,
            default => $hue,
        };

        $result = match (true) {
            $h < (1.0 / 6.0) => $a + ($b - $a) * 6.0 * $h,
            $h < (1.0 / 2.0) => $b,
            $h < (2.0 / 3.0) => $a + ($b - $a) * (2.0 / 3.0 - $h) * 6.0,
            default => $a,
        };

        return (int) round($result * 255.0);
    }
}
