<?php

declare(strict_types=1);

namespace Usarise\Identicon\Color;

use Usarise\Identicon\Exception\InvalidArgumentException;

final class Color {
    /**
     * @var string
     */
    public const DEFAULT_BACKGROUND = '#F0F0F0';

    /**
     * @var string
     */
    public const FORMAT = '#%02x%02x%02x';

    public function __construct(
        public readonly ?string $background,
        public readonly ?string $fill,
    ) {
        if ($background !== null && !$this->formatValidation($background)) {
            throw new InvalidArgumentException('Invalid background format');
        }

        if ($fill !== null && !$this->formatValidation($fill)) {
            throw new InvalidArgumentException('Invalid fill format');
        }
    }

    /**
     * @param non-empty-array<int, int<0, 255>> $bytes
     */
    public function generate(array $bytes): string {
        if (\count($bytes) < 4) {
            throw new InvalidArgumentException('Bytes array length must be a minimum of 4 elements');
        }

        // Use last 28 bits to determine HSL values.
        // source - https://github.com/dgraham/identicon/blob/v0.2.1/src/lib.rs#L28
        [$h0, $h2, $s, $l] = \array_slice($bytes, -4);

        $h1 = ($h0 & 0x0F) << 8;
        $h = ($h1 | $h2);

        // https://processing.org/reference/map_.html
        $map = static fn(int $value, int $vmin, int $vmax, int $dmin, int $dmax): float => (($value - $vmin) * ($dmax - $dmin)) / (($vmax - $vmin) + $dmin);

        $hue = $map($h, 0, 4095, 0, 360);
        $sat = $map($s, 0, 255, 0, 20);
        $lum = $map($l, 0, 255, 0, 20);

        $hsl = new Hsl($hue, 65.0 - $sat, 75.0 - $lum);
        $rgb = $hsl->rgb();

        return sprintf(
            self::FORMAT,
            ...$rgb,
        );
    }

    public function formatValidation(string $hexColorCode): bool {
        if (\strlen($hexColorCode) !== 7) {
            return false;
        }

        $hexDigit = ltrim(
            string: $hexColorCode,
            characters: '#',
        );

        return ctype_xdigit($hexDigit) && \strlen($hexDigit) === 6;
    }
}
