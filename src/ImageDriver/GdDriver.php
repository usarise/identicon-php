<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;

final class GdDriver implements ImageDriverInterface {
    public function __construct() {
        if (!\extension_loaded('gd')) {
            throw new RuntimeException(
                'The "gd" extension is not available',
            );
        }
    }

    public function canvas(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): ImageDrawInterface {
        $image = imagecreate(
            width: $size,
            height: $size,
        );

        return new GdDraw(
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
