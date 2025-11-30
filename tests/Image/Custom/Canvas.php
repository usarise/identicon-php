<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image\Custom;

use Usarise\Identicon\Image\CanvasInterface;

final class Canvas implements CanvasInterface {
    public function draw(
        int $size,
        int $pixelSize,
        string $background,
        string $foreground,
    ): Draw {
        return new Draw();
    }
}
