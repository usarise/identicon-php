<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image;

use Jcupitt\Vips;
use PHPUnit\Framework\TestCase;
use Usarise\Identicon\{Identicon, Resolution};
use Usarise\Identicon\Image\Vips\Canvas as VipsCanvas;

final class VipsCanvasTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 120;

    private ?string $libvipsPath = null;

    protected function setUp(): void {
        $vipsLibPath = getenv('VIPS_LIB_PATH');

        if (\in_array($vipsLibPath, [false, 'false', '0'], true)) {
            $this->markTestSkipped(
                'The environment variable "VIPS_LIB_PATH" is not set.',
            );
        }

        if ($vipsLibPath && file_exists($vipsLibPath)) {
            $this->libvipsPath = $vipsLibPath;
        }
    }

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            VipsCanvas::class,
            $identicon->canvas,
        );
    }

    public function testGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $generate = $identicon->generate('test');

        $this->assertSame(
            'png',
            $generate->format,
        );

        $this->assertSame(
            'image/png',
            $generate->mimeType,
        );

        $this->assertSame(
            'image/png; charset=binary',
            $finfo->buffer(
                $generate->output,
            ),
        );

        $this->assertSame(
            'image/png; charset=binary',
            $finfo->buffer(
                (string) $generate,
            ),
        );

        $this->assertInstanceOf(
            Vips\Image::class,
            $generate->image,
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.vips.png'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageSizeNonStrict(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: 126,
            sizeNonStrict: true,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/sizeNonStrict/test.vips.png'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.vips.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageForeground(): void {
        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.foreground.vips.png'),
            (string) $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundForeground(): void {
        $identicon = new Identicon(
            new VipsCanvas($this->libvipsPath),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.foreground.vips.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.vips.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.vips.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.vips.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.vips.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            canvas: new VipsCanvas($this->libvipsPath),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.vips.png'),
            (string) $identicon->generate('r'),
        );
    }
}
