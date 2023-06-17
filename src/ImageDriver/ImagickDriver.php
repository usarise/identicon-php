<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Response;

final class ImagickDriver implements ImageDriverInterface {
    private int $size;
    private int $pixelSize;
    private \ImagickDraw $image;
    private \ImagickPixel $background;

    public function __construct() {
        if (!\extension_loaded('imagick')) {
            throw new RuntimeException(
                'The imagick extension is not available',
            );
        }
    }

    public function canvas(int $size, int $pixelSize, string $background, string $fill): self {
        $image = new \ImagickDraw();

        $image->setFillColor(
            new \ImagickPixel($fill),
        );

        $this->size = $size;
        $this->pixelSize = $pixelSize;
        $this->image = $image;
        $this->background = new \ImagickPixel($background);

        return $this;
    }

    public function drawPixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize - 1;

        $this->image->rectangle(
            $x,
            $y,
            $x + $pixelSize,
            $y + $pixelSize,
        );
    }

    public function response(): Response {
        $imagick = new \Imagick();

        $imagick->newImage(
            $this->size,
            $this->size,
            $this->background,
        );

        $imagick->setImageFormat('png');
        $imagick->drawImage($this->image);

        $imagick->setOption('png:compression-level', '9');
        $imagick->stripImage();

        return new Response(
            'png',
            'image/png',
            $imagick->getImagesBlob(),
        );
    }
}
