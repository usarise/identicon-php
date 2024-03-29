<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Image\Imagick\Canvas as ImagickCanvas;
use Usarise\Identicon\{Identicon, Resolution};

final class ImagickCanvasTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 120;

    protected function setUp(): void {
        if (!\extension_loaded('imagick')) {
            $this->markTestSkipped(
                'The imagick extension is not available.',
            );
        }
    }

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new ImagickCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            ImagickCanvas::class,
            $identicon->canvas,
        );
    }

    public function testGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new ImagickCanvas(),
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
            \Imagick::class,
            $generate->image,
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new ImagickCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.imagick.png'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new ImagickCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.imagick.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageForeground(): void {
        $identicon = new Identicon(
            new ImagickCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.foreground.imagick.png'),
            (string) $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundForeground(): void {
        $identicon = new Identicon(
            new ImagickCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.foreground.imagick.png'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            canvas: new ImagickCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.imagick.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            canvas: new ImagickCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.imagick.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            canvas: new ImagickCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.imagick.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            canvas: new ImagickCanvas(),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.imagick.png'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            canvas: new ImagickCanvas(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.imagick.png'),
            (string) $identicon->generate('r'),
        );
    }
}
