<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;

final class GdDriver implements ImageDriverInterface {
    private int $color;
    private int $pixelSize;
    private \GdImage $image;

    public function __construct() {
        if (!\extension_loaded('gd')) {
            throw new RuntimeException(
                'The gd extension is not available',
            );
        }
    }

    public function draw(int $size, int $pixelSize, string $background, string $fill): self {
        $image = imagecreate(
            $size,
            $size,
        );

        $this->color = $this->color(
            $image,
            $fill,
        );

        imagefill(
            image: $image,
            x: 0,
            y: 0,
            color: $this->color(
                $image,
                $background,
            ),
        );

        $this->pixelSize = $pixelSize;
        $this->image = $image;

        return $this;
    }

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize - 1;

        imagefilledrectangle(
            $this->image,
            $x,
            $y,
            $x + $pixelSize,
            $y + $pixelSize,
            $this->color,
        );
    }

    public function getImageBlob(): string {
        ob_start();

        imagepng(
            image: $this->image,
            quality: 9,
        );

        $imageBlob = ob_get_contents();
        ob_end_clean();

        return (string) $imageBlob;
    }

    private function color(\GdImage $image, string $color): int {
        return imagecolorallocate(
            $image,
            ...sscanf(
                $color,
                Color::FORMAT,
            ),
        );
    }
}
