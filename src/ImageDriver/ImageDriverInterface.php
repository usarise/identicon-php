<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

interface ImageDriverInterface {
    public function canvas(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): ImageDrawInterface;
}
