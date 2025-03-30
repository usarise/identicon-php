<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\{Identicon, Resolution};
use Usarise\Identicon\Image\Gd\Canvas as GdCanvas;

final class GdCanvasTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 120;

    protected function setUp(): void {
        if (!\extension_loaded('gd')) {
            $this->markTestSkipped(
                'The gd extension is not available.',
            );
        }
    }

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            GdCanvas::class,
            $identicon->canvas,
        );
    }

    public function testGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $generate = $identicon->generate('test');

        $this->assertEquals(
            'png',
            $generate->format,
        );

        $this->assertEquals(
            'image/png',
            $generate->mimeType,
        );

        $this->assertEquals(
            'image/png; charset=binary',
            $finfo->buffer(
                $generate->output,
            ),
        );

        $this->assertEquals(
            'image/png; charset=binary',
            $finfo->buffer(
                (string) $generate,
            ),
        );

        $this->assertInstanceOf(
            \GdImage::class,
            $generate->image,
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.gd.png'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.gd.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageForeground(): void {
        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.foreground.gd.png'),
            (string) $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundForeground(): void {
        $identicon = new Identicon(
            new GdCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.foreground.gd.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            canvas: new GdCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.gd.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            canvas: new GdCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.gd.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            canvas: new GdCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.gd.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            canvas: new GdCanvas(),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.gd.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            canvas: new GdCanvas(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.gd.png'),
            (string) $identicon->generate('r'),
        );
    }
}
