<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\ImageDriver\ImageDriverInterface;

final class Identicon {
    /**
     * @var int
     */
    public const IMAGE_SIZE = 420;
    /**
     * @var string
     */
    public const IMAGE_BACKGROUND = '#F0F0F0';

    public function __construct(
        public readonly ImageDriverInterface $image,
        public readonly Resolution $resolution = Resolution::Medium,
    ) {
    }

    /**
     * @param non-empty-array<int, int> $bytes
     */
    public function getFillColor(array $bytes): string {
        // Use last 28 bits to determine HSL values.
        // source - https://github.com/dgraham/identicon/blob/v0.2.1/src/lib.rs#L28
        [$h0, $h2, $s, $l] = \array_slice($bytes, -4);

        $h1 = ($h0 & 0x0F) << 8;
        $h = ($h1 | $h2);

        // https://processing.org/reference/map_.html
        $map = static fn (int $value, int $vmin, int $vmax, int $dmin, int $dmax): float => (($value - $vmin) * ($dmax - $dmin)) / (($vmax - $vmin) + $dmin);

        $hue = $map($h, 0, 4095, 0, 360);
        $sat = $map($s, 0, 255, 0, 20);
        $lum = $map($l, 0, 255, 0, 20);

        $hsl = new Hsl($hue, 65.0 - $sat, 75.0 - $lum);
        $rgb = $hsl->rgb();

        return sprintf('#%02x%02x%02x', ...$rgb);
    }

    public function generate(string $str, ?string $background = null, ?string $fill = null): string {
        if ($background !== null && !$this->hexColorValidation($background)) {
            throw new InvalidArgumentException('Invalid background format');
        }

        if ($fill !== null && !$this->hexColorValidation($fill)) {
            throw new InvalidArgumentException('Invalid fill format');
        }

        $binary = new Binary($this->resolution);
        $bytes = $binary->getBytes($str);

        $blockSize = floor(self::IMAGE_SIZE / $this->resolution->value);
        $pixels = $binary->getPixels(
            $binary->getBinStr($bytes),
        );

        $draw = $this->image->draw(
            $background ?? self::IMAGE_BACKGROUND,
            $fill ?? $this->getFillColor($bytes),
        );

        foreach (range(0, self::IMAGE_SIZE) as $x) {
            foreach (range(0, self::IMAGE_SIZE) as $y) {
                $xBlockSize = (int) floor($x / $blockSize);
                $yBlockSize = (int) floor($y / $blockSize);

                if (!isset(
                    $pixels[$xBlockSize],
                    $pixels[$xBlockSize][$yBlockSize],
                )) {
                    continue;
                }

                if ($pixels[$xBlockSize][$yBlockSize] === 1) {
                    $draw->pixel($x, $y);
                }
            }
        }

        return $draw->getImageBlob();
    }

    public function hexColorValidation(string $hexColor): bool {
        if (\strlen($hexColor) !== 7) {
            return false;
        }

        $hex = ltrim(
            $hexColor,
            '#',
        );

        return ctype_xdigit($hex) && \strlen($hex) === 6;
    }
}
