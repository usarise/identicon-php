<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\ImageDriver\GdDriver;
use Usarise\Identicon\{Identicon, Resolution};

final class GdDriverTest extends TestCase {
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
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            GdDriver::class,
            $identicon->image,
        );
    }

    public function testImageGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            'image/png; charset=binary',
            $finfo->buffer(
                $identicon->generate('test'),
            ),
        );
    }

    public function testImageDefault(): void {
        $identicon = new Identicon(
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/default/test.gd.png'),
            $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.gd.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageFill(): void {
        $identicon = new Identicon(
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.fill.gd.png'),
            $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundFill(): void {
        $identicon = new Identicon(
            new GdDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/color/test.background.fill.gd.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            image: new GdDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            image: new GdDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            image: new GdDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            image: new GdDriver(),
            size: 126,
            resolution: Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            image: new GdDriver(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.gd.png'),
            $identicon->generate('r'),
        );
    }
}
