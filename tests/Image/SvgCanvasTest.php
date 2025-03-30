<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\{Identicon, Resolution};
use Usarise\Identicon\Image\Svg\{Canvas as SvgCanvas, Svg};

final class SvgCanvasTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 120;

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            SvgCanvas::class,
            $identicon->canvas,
        );
    }

    public function testGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $generate = $identicon->generate('test');

        $this->assertEquals(
            'svg',
            $generate->format,
        );

        $this->assertEquals(
            'image/svg+xml',
            $generate->mimeType,
        );

        $this->assertEquals(
            'image/svg+xml; charset=us-ascii',
            $finfo->buffer(
                $generate->output,
            ),
        );

        $this->assertEquals(
            'image/svg+xml; charset=us-ascii',
            $finfo->buffer(
                (string) $generate,
            ),
        );

        $this->assertInstanceOf(
            Svg::class,
            $generate->image,
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.svg'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageRectsReset(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        // rects variable
        $identicon->generate('test');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.svg'),
            (string) $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.svg'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageForeground(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.foreground.svg'),
            (string) $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundForeground(): void {
        $identicon = new Identicon(
            new SvgCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.foreground.svg'),
            (string) $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            canvas: new SvgCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.svg'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            canvas: new SvgCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.svg'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            canvas: new SvgCanvas(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.svg'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            canvas: new SvgCanvas(),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.svg'),
            (string) $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            canvas: new SvgCanvas(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.svg'),
            (string) $identicon->generate('r'),
        );
    }
}
