<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Vips;

use Jcupitt\Vips\{BandFormat, Extend, Image, Interpretation};
use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Image\CanvasInterface;

/**
 * @api
 */
final class Canvas implements CanvasInterface {
    public function __construct() {
        if (!class_exists(Image::class)) {
            throw new RuntimeException(
                'The "jcupitt/vips" binding for libvips is not install',
            );
        }
    }

    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): Draw {
        return new Draw(
            $this->image(
                $size,
                $background,
            ),
            sscanf(
                $foreground,
                Color::FORMAT,
            ),
            $pixelSize,
        );
    }

    private function image(int $size, string $background): Image {
        return Image::black(
            $size,
            $size,
        )
        ->add(
            sscanf(
                $background,
                Color::FORMAT,
            ),
        )
        ->cast(
            BandFormat::UCHAR,
        )
        ->embed(
            0,
            0,
            $size,
            $size,
            ['extend' => Extend::COPY],
        )
        ->copy(
            ['interpretation' => Interpretation::RGB],
        )
        ;
    }
}
