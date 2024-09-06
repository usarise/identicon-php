<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Svg;

use Usarise\Identicon\Image\DrawInterface;
use Usarise\Identicon\Response;

/**
 * @api
 */
final class Draw implements DrawInterface {
    public function __construct(
        private readonly Svg $svg,
        private readonly int $pixelSize,
    ) {}

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->svg->drawRect(
            x: $x,
            y: $y,
            width: $pixelSize,
            height: $pixelSize,
        );
    }

    public function response(): Response {
        return new Response(
            format: 'svg',
            mimeType: 'image/svg+xml',
            output: $this->svg->generate(minimize: true),
            image: $this->svg,
        );
    }
}
