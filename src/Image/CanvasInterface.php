<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image;

/**
 * @api
 */
interface CanvasInterface {
    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): DrawInterface;
}
