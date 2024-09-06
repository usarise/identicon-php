<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Imagick;

use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Image\{CanvasInterface, DrawInterface};

/**
 * @api
 */
final class Canvas implements CanvasInterface {
    public function __construct() {
        if (!\extension_loaded('imagick')) {
            throw new RuntimeException(
                'The "imagick" extension is not available',
            );
        }
    }

    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): DrawInterface {
        return new Draw(
            $this->image(
                $size,
                $background,
            ),
            $this->pixels(
                $foreground,
            ),
            $pixelSize - 1,
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

    private function pixels(string $foreground): \ImagickDraw {
        $pixels = new \ImagickDraw();

        $pixels->setFillColor(
            new \ImagickPixel(
                $foreground,
            ),
        );

        return $pixels;
    }
}
