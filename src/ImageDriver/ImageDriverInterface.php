<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Response;

interface ImageDriverInterface {
    public function canvas(int $size, int $pixelSize, string $background, string $fill): self;

    public function drawPixel(int $x, int $y): void;

    public function response(): Response;
}
