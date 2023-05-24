<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use Usarise\Identicon\ImageDriver\ImageDriverInterface;
use Usarise\Identicon\Response;

final class CustomDriver implements ImageDriverInterface {
    public function canvas(int $size, int $pixelSize, string $background, string $fill): self {
        return $this;
    }

    public function drawPixel(int $x, int $y): void {
    }

    public function response(): Response {
        return new Response(
            'tmp',
            'test response',
        );
    }
}
