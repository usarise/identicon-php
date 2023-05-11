<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\ImageDriver\ImageDriverInterface;

final class Identicon {
    public function __construct(
        public readonly ImageDriverInterface $image,
        public readonly int $size,
        public readonly Resolution $resolution = Resolution::Medium,
    ) {
        $resolutionValue = $this->resolution->value;

        if (($size % $resolutionValue) !== 0) {
            throw new InvalidArgumentException(
                sprintf(
                    'Size must be a multiple of %d',
                    $resolutionValue,
                ),
            );
        }
    }

    public function generate(string $str, ?string $background = null, ?string $fill = null): string {
        $color = new Color(
            $background,
            $fill,
        );

        $binary = new Binary(
            $this->resolution,
        );

        $bytes = $binary->getBytes(
            $str,
        );

        $pixels = $binary->getPixels(
            $binary->getBinStr($bytes),
        );

        $size = $this->size;
        $blockSize = floor($size / $this->resolution->value);

        $draw = $this->image->draw(
            $size,
            $color->background ?? Color::DEFAULT_BACKGROUND,
            $color->fill ?? $color->generate($bytes),
        );

        foreach (range(0, $size) as $x) {
            foreach (range(0, $size) as $y) {
                $xBlockSize = (int) floor($x / $blockSize);
                $yBlockSize = (int) floor($y / $blockSize);

                if (!isset(
                    $pixels[$xBlockSize],
                    $pixels[$xBlockSize][$yBlockSize],
                )) {
                    continue;
                }

                if ($pixels[$xBlockSize][$yBlockSize] === 1) {
                    $draw->pixel($x, $y);
                }
            }
        }

        return $draw->getImageBlob();
    }
}
