<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Svg;

use Usarise\Identicon\Image\DrawInterface;
use Usarise\Identicon\Response;

final class Draw implements DrawInterface {
    public function __construct(
        private readonly int $pixelSize,
        private readonly string $foreground,
        private readonly Svg $svg,
    ) {}

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->svg->drawRect(
            x: $x,
            y: $y,
            width: $pixelSize,
            height: $pixelSize,
            foreground: $this->foreground,
        );
    }

    public function response(): Response {
        return new Response(
            format: 'svg',
            mimeType: 'image/svg+xml',
            output: $this->svg->image(minimize: true),
            image: $this->svg,
        );
    }
}
