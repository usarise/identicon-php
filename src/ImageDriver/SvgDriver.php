<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Response;

final class SvgDriver implements ImageDriverInterface {
    private int $size;
    private int $pixelSize;
    private string $background;
    private string $fill;
    /**
     * @var array<int, string>
     */
    private array $pixels;

    public function canvas(int $size, int $pixelSize, string $background, string $fill): self {
        $this->size = $size;
        $this->pixelSize = $pixelSize;
        $this->background = $background;
        $this->fill = $fill;
        $this->pixels = [];

        return $this;
    }

    public function drawPixel(int $x, int $y): void {
        $pixelSize = $this->pixelSize;

        $this->pixels[] = $this->createSvgRect(
            $x,
            $y,
            $pixelSize,
            $pixelSize,
            $this->fill,
        );
    }

    public function response(): Response {
        $minimizeImageSvg = static fn (string $imageSvg): string => str_replace(
            ["\n", "\x20\x20"],
            '',
            $imageSvg,
        );

        $imageSvg = $this->createSvg(
            $this->size,
            $this->background,
            $this->pixels,
        );

        return new Response(
            format: 'svg',
            mimeType: 'image/svg+xml',
            output: $minimizeImageSvg($imageSvg),
        );
    }

    /**
     * @param array<int, string> $pixels
     */
    private function createSvg(int $size, string $background, array $pixels): string {
        $background = $this->createSvgRect(
            0,
            0,
            $size,
            $size,
            $background,
        );

        $pixels = implode(
            separator: "\n\x20\x20",
            array: $pixels,
        );

        return <<<XML
            <?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg version="1.1"
                 width="{$size}px" height="{$size}px"
                 viewBox="0 0 {$size} {$size}"
                 xmlns="http://www.w3.org/2000/svg">

              {$background}
              {$pixels}
            </svg>
            XML;
    }

    private function createSvgRect(int $x, int $y, int $width, int $height, string $fill): string {
        return <<<XML
            <rect x="{$x}px" y="{$y}px" width="{$width}px" height="{$height}px" fill="{$fill}"/>
            XML;
    }
}
