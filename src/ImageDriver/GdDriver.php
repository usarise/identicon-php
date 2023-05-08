<?php

declare(strict_types=1);

namespace Usarise\Identicon\ImageDriver;

use Usarise\Identicon\Identicon;

final class GdDriver implements ImageDriverInterface {
    private \GdImage $image;
    private int $fill;

    public function draw(string $background, string $fill): self {
        $size = Identicon::IMAGE_SIZE;
        $image = imagecreate($size, $size);

        $fill = sscanf($fill, '#%02x%02x%02x');
        $fill = imagecolorallocate($image, ...$fill);
        $background = sscanf($background, '#%02x%02x%02x');

        imagefill(
            image: $image,
            x: 0,
            y: 0,
            color: imagecolorallocate(
                $image,
                ...$background,
            ),
        );

        $this->image = $image;
        $this->fill = $fill;

        return $this;
    }

    public function pixel(int $x, int $y): void {
        imagesetpixel(
            $this->image,
            $x,
            $y,
            $this->fill,
        );
    }

    public function getImageBlob(): string {
        ob_start();

        imagepng(
            image: $this->image,
            quality: 9,
        );

        $imageBlob = ob_get_contents();
        ob_end_clean();

        return (string) $imageBlob;
    }
}
