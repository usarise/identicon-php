<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Identicon;

final class ImagickDriver implements ImageDriverInterface {
    private \ImagickDraw $image;
    private \ImagickPixel $background;

    public function draw(string $background, string $fill): self {
        $image = new \ImagickDraw();

        $image->setFillColor(
            new \ImagickPixel($fill),
        );

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
            Identicon::IMAGE_SIZE,
            Identicon::IMAGE_SIZE,
            $this->background,
        );

        $imagick->setImageFormat('png');
        $imagick->drawImage($this->image);

        $imagick->setOption('png:compression-level', '9');
        $imagick->stripImage();

        return $imagick->getImagesBlob();
    }
}
