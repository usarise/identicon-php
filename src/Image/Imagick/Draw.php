<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Imagick;

use Usarise\Identicon\Image\DrawInterface;
use Usarise\Identicon\Response;

final class Draw implements DrawInterface {
    public function __construct(
        private readonly int $pixelSize,
        private readonly \ImagickDraw $pixels,
        private readonly \Imagick $image,
    ) {}

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->pixels->rectangle(
            $x,
            $y,
            $x + $pixelSize,
            $y + $pixelSize,
        );
    }

    public function response(): Response {
        $this->image->drawImage(
            $this->pixels,
        );

        return new Response(
            format: 'png',
            mimeType: 'image/png',
            output: $this->output($this->image),
            image: $this->image,
        );
    }

    private function output(\Imagick $imagick): string {
        $imagick->setImageFormat('png');
        $imagick->setOption('png:compression-level', '9');
        $imagick->stripImage();

        return $imagick->getImagesBlob();
    }
}
