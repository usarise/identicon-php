<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Response;

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

    public function canvas(int $size, int $pixelSize, string $background, string $fill): self {
        $color = static fn (\GdImage $image, string $hexColorCode): int => imagecolorallocate(
            $image,
            ...sscanf(
                $hexColorCode,
                Color::FORMAT,
            ),
        );

        $image = imagecreate(
            $size,
            $size,
        );

        $this->color = $color(
            $image,
            $fill,
        );

        imagefill(
            image: $image,
            x: 0,
            y: 0,
            color: $color(
                $image,
                $background,
            ),
        );

        $this->pixelSize = $pixelSize - 1;
        $this->image = $image;

        return $this;
    }

    public function drawPixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        imagefilledrectangle(
            $this->image,
            $x,
            $y,
            $x + $pixelSize,
            $y + $pixelSize,
            $this->color,
        );
    }

    public function response(): Response {
        ob_start();

        imagepng(
            image: $this->image,
            quality: 9,
        );

        $imageBlob = ob_get_contents();
        ob_end_clean();

        return new Response(
            'png',
            'image/png',
            (string) $imageBlob,
        );
    }
}
