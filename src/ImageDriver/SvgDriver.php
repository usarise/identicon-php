<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Response;

final class SvgDriver implements ImageDriverInterface {
    private int $size;
    private int $pixelSize;
    private string $background;
    private string $fill;
    private string $pixels;

    public function canvas(int $size, int $pixelSize, string $background, string $fill): self {
        $this->size = $size;
        $this->pixelSize = $pixelSize;
        $this->background = $background;
        $this->fill = $fill;
        $this->pixels = '';

        return $this;
    }

    public function drawPixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->pixels .= '<rect x="' .
                         $x . 'px" y="' .
                         $y . 'px" width="' .
                         $pixelSize . 'px" height="' .
                         $pixelSize .
                         'px" fill="' .
                         $this->fill .
                         '"/>';
    }

    public function response(): Response {
        $size = $this->size;

        return new Response(
            'svg',
            'image/svg+xml',
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' .
            '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' .
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" ' .
            'x="0px" y="0px" width="' .
            $size . 'px" height="' .
            $size . 'px" viewBox="0 0 ' .
            $size . ' ' .
            $size . '" enable-background="new 0 0 ' .
            $size . ' ' .
            $size . '" xml:space="preserve">' .
            '<rect x="0px" y="0px" width="' .
            $size . 'px" height="' .
            $size . 'px" fill="' .
            $this->background . '"/>' .
            $this->pixels . '</svg>',
        );
    }
}
