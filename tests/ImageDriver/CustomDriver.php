<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use Usarise\Identicon\ImageDriver\ImageDriverInterface;

final class CustomDriver implements ImageDriverInterface {
    public function draw(int $size, string $background, string $fill): self {
        return $this;
    }

    public function pixel(int $x, int $y): void {
    }

    public function getImageBlob(): string {
        return '';
    }
}
