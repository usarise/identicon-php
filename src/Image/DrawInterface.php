<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image;

use Usarise\Identicon\Response;

/**
 * @api
 */
interface DrawInterface {
    public function pixel(int $x, int $y): void;

    public function response(): Response;
}
