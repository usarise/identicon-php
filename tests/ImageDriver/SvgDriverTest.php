<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\ImageDriver\SvgDriver;
use Usarise\Identicon\{Identicon, Resolution};

final class SvgDriverTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 120;

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            SvgDriver::class,
            $identicon->image,
        );
    }

    public function testImageGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            'image/svg+xml; charset=us-ascii',
            $finfo->buffer(
                $identicon->generate('test'),
            ),
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.svg'),
            $identicon->generate('test'),
        );
    }

    public function testImagePixelsReset(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        // fill pixels variable
        $identicon->generate('test');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.svg'),
            $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.svg'),
            $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageFill(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.fill.svg'),
            $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundFill(): void {
        $identicon = new Identicon(
            new SvgDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.fill.svg'),
            $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            image: new SvgDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.svg'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            image: new SvgDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.svg'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            image: new SvgDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.svg'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            image: new SvgDriver(),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.svg'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            image: new SvgDriver(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.svg'),
            $identicon->generate('r'),
        );
    }
}
