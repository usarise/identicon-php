<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Response;

interface ImageDrawInterface {
    public function pixel(int $x, int $y): void;

    public function response(): Response;
}
