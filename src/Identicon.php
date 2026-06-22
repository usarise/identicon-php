<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\Image\CanvasInterface;

/**
 * @api
 */
final class Identicon {
    public function __construct(
        public readonly CanvasInterface $canvas,
        public readonly int $size,
        public readonly Resolution $resolution = Resolution::Medium,
        public readonly bool $sizeNonStrict = false,
    ) {
        if ($size <= 0) {
            throw new InvalidArgumentException(
                'Size cannot be negative or zero',
            );
        }

        if (!$sizeNonStrict) {
            $resolutionValue = $this->resolution->value;

            if (($size % $resolutionValue) !== 0) {
                $binary = new Binary(
                    $this->resolution,
                );

                throw new InvalidArgumentException(
                    \sprintf(
                        'Size must be a multiple of %d. The closest acceptable size %d',
                        $resolutionValue,
                        $binary->getMultipleSize($size),
                    ),
                );
            }
        }
    }

    public function generate(string $string, ?string $background = null, ?string $foreground = null): Response {
        $color = new Color(
            $background,
            $foreground,
        );

        $binary = new Binary(
            $this->resolution,
        );

        $bytes = $binary->getBytes(
            $string,
        );

        $pixels = $binary->getPixels(
            $binary->getBinStr($bytes),
        );

        $padding = 0;
        $size = $this->size;

        $multipleSize = $this->sizeNonStrict ? $binary->getMultipleSize($size) : $size;
        $pixelSize = (int) floor($multipleSize / $this->resolution->value);

        if ($this->sizeNonStrict) {
            $padding = $multipleSize - $size;

            if ($padding > 0) {
                $padding = (int) ceil($padding / 2);
            }
        }

        $draw = $this->canvas->draw(
            $size,
            $pixelSize,
            $color->background ?? Color::DEFAULT_BACKGROUND,
            $color->foreground ?? $color->generate($bytes),
        );

        foreach (range(0, $multipleSize, $pixelSize) as $x) {
            foreach (range(0, $multipleSize, $pixelSize) as $y) {
                $xBlock = (int) floor($x / $pixelSize);
                $yBlock = (int) floor($y / $pixelSize);

                if (!isset(
                    $pixels[$xBlock],
                    $pixels[$xBlock][$yBlock],
                )) {
                    continue;
                }

                if ($pixels[$xBlock][$yBlock] === 1) {
                    if ($padding > 0) {
                        $draw->pixel(
                            x: $x - $padding,
                            y: $y - $padding,
                        );

                        continue;
                    }

                    $draw->pixel($x, $y);
                }
            }
        }

        return $draw->response();
    }
}
