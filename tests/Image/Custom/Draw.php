<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image\Custom;

use Usarise\Identicon\Image\DrawInterface;
use Usarise\Identicon\Response;

final class Draw implements DrawInterface {
    public function pixel(int $x, int $y): void {}

    public function response(): Response {
        return new Response(
            'tmp',
            'text/plain',
            'test response',
        );
    }
}
