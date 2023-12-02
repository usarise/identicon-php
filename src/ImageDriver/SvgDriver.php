<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

final class SvgDriver implements ImageDriverInterface {
    public function canvas(
        int $size,
        int $pixelSize,
        string $background,
        string $fill,
    ): ImageDrawInterface {
        return new SvgDraw(
            $pixelSize,
            $fill,
            new Svg(
                $size,
                $background,
            ),
        );
    }
}
