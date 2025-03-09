<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Gd;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Image\{CanvasInterface, DrawInterface};

/**
 * @api
 */
final class Canvas implements CanvasInterface {
    public function __construct() {
        if (!\extension_loaded('gd')) {
            throw new RuntimeException(
                'The "gd" extension is not available',
            );
        }
    }

    /**
     * @param int<1, max> $size
     * @param int<1, max> $pixelSize
     */
    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): DrawInterface {
        $image = imagecreate(
            width: $size,
            height: $size,
        );

        return new Draw(
            $this->image(
                $image,
                $background,
            ),
            $this->color(
                $image,
                $foreground,
            ),
            $pixelSize - 1,
        );
    }

    private function image(\GdImage $image, string $background): \GdImage {
        imagefill(
            image: $image,
            x: 0,
            y: 0,
            color: $this->color(
                $image,
                $background,
            ),
        );

        return $image;
    }

    private function color(\GdImage $image, string $cssHexColor): int {
        $color = imagecolorallocate(
            $image,
            ...sscanf(
                $cssHexColor,
                Color::FORMAT,
            ),
        );

        if ($color === false) {
            throw new RuntimeException(
                'Color allocation failed',
            );
        }

        return $color;
    }
}
