<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Response;

final class GdDraw implements ImageDrawInterface {
    public function __construct(
        private readonly int $pixelSize,
        private readonly int $fill,
        private readonly \GdImage $image,
    ) {}

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        imagefilledrectangle(
            $this->image,
            $x,
            $y,
            $x + $pixelSize,
            $y + $pixelSize,
            $this->fill,
        );
    }

    public function response(): Response {
        $image = $this->image;

        return new Response(
            format: 'png',
            mimeType: 'image/png',
            output: $this->output($image),
            image: $image,
        );
    }

    private function output(\GdImage $image): string {
        ob_start();

        imagepng(
            image: $image,
            quality: 9,
        );

        $imageBlob = ob_get_contents();
        ob_end_clean();

        return (string) $imageBlob;
    }
}
