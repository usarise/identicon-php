<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Gd;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Image\{CanvasInterface, DrawInterface};

final class Canvas implements CanvasInterface {
    public function __construct() {
        if (!\extension_loaded('gd')) {
            throw new RuntimeException(
                'The "gd" extension is not available',
            );
        }
    }

    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): DrawInterface {
        $image = imagecreate(
            width: $size,
            height: $size,
        );

        return new Draw(
            pixelSize: $pixelSize - 1,
            fill: $this->color(
                $image,
                $fill,
            ),
            image: $this->image(
                $image,
                $background,
            ),
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

    private function color(\GdImage $image, string $hexColorCode): int {
        return imagecolorallocate(
            $image,
            ...sscanf(
                $hexColorCode,
                Color::FORMAT,
            ),
        );
    }
}
