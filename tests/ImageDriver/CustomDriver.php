<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use Usarise\Identicon\ImageDriver\{ImageDrawInterface, ImageDriverInterface};

final class CustomDriver implements ImageDriverInterface {
    public function canvas(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): ImageDrawInterface {
        return new CustomDraw();
    }
}
