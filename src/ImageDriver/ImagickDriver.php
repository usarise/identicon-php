<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

final class ImagickDriver implements ImageDriverInterface {
    private int $size;
    private \ImagickDraw $image;
    private \ImagickPixel $background;

    public function draw(int $size, string $background, string $fill): self {
        $image = new \ImagickDraw();

        $image->setFillColor(
            new \ImagickPixel($fill),
        );

        $this->size = $size;
        $this->image = $image;
        $this->background = new \ImagickPixel($background);

        return $this;
    }

    public function pixel(int $x, int $y): void {
        $this->image->point($x, $y);
    }

    public function getImageBlob(): string {
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

        return $imagick->getImagesBlob();
    }
}
