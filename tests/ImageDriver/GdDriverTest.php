<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\ImageDriver\GdDriver;
use Usarise\Identicon\{Identicon, Resolution};

final class GdDriverTest extends TestCase {
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
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.gd.png'),
            $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new GdDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.background.gd.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageFill(): void {
        $identicon = new Identicon(
            new GdDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.fill.gd.png'),
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
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.background.fill.gd.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            new GdDriver(),
            Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            new GdDriver(),
            Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            new GdDriver(),
            Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            new GdDriver(),
            Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.gd.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            new GdDriver(),
            Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.gd.png'),
            $identicon->generate('r'),
        );
    }
}
