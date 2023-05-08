<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\ImageDriver;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\ImageDriver\ImagickDriver;
use Usarise\Identicon\{Identicon, Resolution};

final class ImagickDriverTest extends TestCase {
    protected function setUp(): void {
        if (!\extension_loaded('imagick')) {
            $this->markTestSkipped(
                'The imagick extension is not available.',
            );
        }
    }

    public function testImageDriverLoad(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
        );

        $this->assertInstanceOf(
            ImagickDriver::class,
            $identicon->image,
        );
    }

    public function testImageGenerate(): void {
        $finfo = new \finfo(FILEINFO_MIME);

        $identicon = new Identicon(
            new ImagickDriver(),
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
            new ImagickDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.imagick.png'),
            $identicon->generate('test'),
        );
    }

    public function testImageBackground(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.background.imagick.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
            ),
        );
    }

    public function testImageFill(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.fill.imagick.png'),
            $identicon->generate(
                'test',
                null,
                '#84c7b5',
            ),
        );
    }

    public function testImageBackgroundFill(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/test.background.fill.imagick.png'),
            $identicon->generate(
                'test',
                '#f2f1f2',
                '#84c7b5',
            ),
        );
    }

    public function testImageResolutionTiny(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
            Resolution::Tiny,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.tiny.imagick.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionSmall(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
            Resolution::Small,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.small.imagick.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionMedium(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
            Resolution::Medium,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.medium.imagick.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionLarge(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
            Resolution::Large,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.large.imagick.png'),
            $identicon->generate('r'),
        );
    }

    public function testImageResolutionHuge(): void {
        $identicon = new Identicon(
            new ImagickDriver(),
            Resolution::Huge,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/resolution/r.huge.imagick.png'),
            $identicon->generate('r'),
        );
    }
}
