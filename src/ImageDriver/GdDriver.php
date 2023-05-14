<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;

final class GdDriver implements ImageDriverInterface {
    private int $color;
    private \GdImage $image;

    public function __construct() {
        if (!\extension_loaded('gd')) {
            throw new RuntimeException(
                'The gd extension is not available',
            );
        }
    }

    public function draw(int $size, string $background, string $fill): self {
        $image = imagecreate(
            $size,
            $size,
        );

        $this->color = imagecolorallocate(
            $image,
            ...sscanf(
                $fill,
                Color::FORMAT,
            ),
        );

        imagefill(
            image: $image,
            x: 0,
            y: 0,
            color: imagecolorallocate(
                $image,
                ...sscanf(
                    $background,
                    Color::FORMAT,
                ),
            ),
        );

        $this->image = $image;

        return $this;
    }

    public function pixel(int $x, int $y): void {
        imagesetpixel(
            $this->image,
            $x,
            $y,
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
}
