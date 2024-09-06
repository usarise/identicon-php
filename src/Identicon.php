<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\Image\CanvasInterface;

final class Identicon {
    public function __construct(
        public readonly CanvasInterface $canvas,
        public readonly int $size,
        public readonly Resolution $resolution = Resolution::Medium,
    ) {
        if ($size <= 0) {
            throw new InvalidArgumentException(
                'Size cannot be negative or zero',
            );
        }

        $resolutionValue = $this->resolution->value;

        if (($size % $resolutionValue) !== 0) {
            throw new InvalidArgumentException(
                \sprintf(
                    'Size must be a multiple of %d',
                    $resolutionValue,
                ),
            );
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

        $size = $this->size;
        $pixelSize = (int) floor($size / $this->resolution->value);

        $draw = $this->canvas->draw(
            $size,
            $pixelSize,
            $color->background ?? Color::DEFAULT_BACKGROUND,
            $color->foreground ?? $color->generate($bytes),
        );

        foreach (range(0, $size, $pixelSize) as $x) {
            foreach (range(0, $size, $pixelSize) as $y) {
                $xBlock = (int) floor($x / $pixelSize);
                $yBlock = (int) floor($y / $pixelSize);

                if (!isset(
                    $pixels[$xBlock],
                    $pixels[$xBlock][$yBlock],
                )) {
                    continue;
                }

                if ($pixels[$xBlock][$yBlock] === 1) {
                    $draw->pixel($x, $y);
                }
            }
        }

        return $draw->response();
    }
}
