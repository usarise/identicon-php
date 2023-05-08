<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

interface ImageDriverInterface {
    public function draw(string $background, string $fill): self;

    public function pixel(int $x, int $y): void;

    public function getImageBlob(): string;
}
