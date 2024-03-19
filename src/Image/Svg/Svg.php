<?php

declare(strict_types=1);

namespace Usarise\Identicon\Image\Svg;

final class Svg {
    /**
     * @var array<int, string>
     */
    private array $rects = [];

    public function __construct(
        public readonly int $size,
        public readonly string $background,
        public readonly string $foreground,
    ) {}

    public function drawRect(int $x, int $y, int $width, int $height): void {
        $this->rects[] = $this->rect(
            $x,
            $y,
            $width,
            $height,
        );
    }

    public function generate(bool $minimize = false): string {
        $size = $this->size;

        $rects = implode(
            separator: "\n\x20\x20\x20\x20",
            array: $this->rects,
        );

        $xmlSvg = <<<XML
            <?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg version="1.1"
                 width="{$size}px" height="{$size}px"
                 viewBox="0 0 {$size} {$size}"
                 xmlns="http://www.w3.org/2000/svg">

              <rect width="{$size}px" height="{$size}px" fill="{$this->background}"/>
              <g fill="{$this->foreground}">
                {$rects}
              </g>
            </svg>
            XML;

        return $minimize ? $this->minimize($xmlSvg) : $xmlSvg;
    }

    private function minimize(string $xmlSvg): string {
        return str_replace(
            search: ["\n", "\x20\x20"],
            replace: '',
            subject: $xmlSvg,
        );
    }

    private function rect(int $x, int $y, int $width, int $height): string {
        return <<<XML
            <rect x="{$x}px" y="{$y}px" width="{$width}px" height="{$height}px"/>
            XML;
    }
}
