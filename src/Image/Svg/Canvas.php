<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Svg;

use Usarise\Identicon\Image\{CanvasInterface, DrawInterface};

final class Canvas implements CanvasInterface {
    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): DrawInterface {
        return new Draw(
            new Svg(
                $size,
                $background,
                $foreground,
            ),
            $pixelSize,
        );
    }
}
