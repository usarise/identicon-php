<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Vips;

use Jcupitt\Vips\ForeignPngFilter;
use Jcupitt\Vips\Image;
use Usarise\Identicon\Image\DrawInterface;
use Usarise\Identicon\Response;

/**
 * @api
 */
final class Draw implements DrawInterface {
    public function __construct(
        private Image $image,

        /**
         * @var array<int<0, 2>, int<0, 255>>
         */
        private readonly array $foreground,
        private readonly int $pixelSize,
    ) {}

    public function pixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->image = $this->image->draw_rect(
            $this->foreground,
            $x,
            $y,
            $pixelSize,
            $pixelSize,
            ['fill' => true],
        );
    }

    public function response(): Response {
        return new Response(
            format: 'png',
            mimeType: 'image/png',
            output: $this->output($this->image),
            image: $this->image,
        );
    }

    private function output(Image $image): string {
        return $image->writeToBuffer(
            '.png',
            [
                'compression' => 9,
                'filter'      => ForeignPngFilter::PAETH,
                'strip' => true,
            ],
        );
    }
}
