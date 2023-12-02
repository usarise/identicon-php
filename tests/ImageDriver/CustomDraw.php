<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use Usarise\Identicon\ImageDriver\ImageDrawInterface;
use Usarise\Identicon\Response;

final class CustomDraw implements ImageDrawInterface {
    public function pixel(int $x, int $y): void {}

    public function response(): Response {
        return new Response(
            'tmp',
            'text/plain',
            'test response',
        );
    }
}
