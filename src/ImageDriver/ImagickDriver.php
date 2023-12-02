<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Exception\RuntimeException;

final class ImagickDriver implements ImageDriverInterface {
    public function __construct() {
        if (!\extension_loaded('imagick')) {
            throw new RuntimeException(
                'The "imagick" extension is not available',
            );
        }
    }

    public function canvas(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): ImageDrawInterface {
        return new ImagickDraw(
            pixelSize: $pixelSize - 1,
            pixels: $this->pixels(
                $fill,
            ),
            image: $this->image(
                $size,
                $background,
            ),
        );
    }

    private function image(int $size, string $background): \Imagick {
        $imagick = new \Imagick();

        $imagick->newImage(
            $size,
            $size,
            new \ImagickPixel(
                $background,
            ),
        );

        return $imagick;
    }

    private function pixels(string $fill): \ImagickDraw {
        $pixels = new \ImagickDraw();

        $pixels->setFillColor(
            new \ImagickPixel(
                $fill,
            ),
        );

        return $pixels;
    }
}
