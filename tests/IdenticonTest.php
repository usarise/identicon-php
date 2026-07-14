<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use Usarise\Identicon\{Binary, Identicon, Resolution};
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\IdenticonTests\Image\Custom\Canvas as CustomCanvas;

final class IdenticonTest extends IdenticonTestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 420;

    public function testCustomCanvas(): void {
        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            CustomCanvas::class,
            $identicon->canvas,
        );
    }

    public function testDefaultValue(): void {
        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertSame(
            12,
            $identicon->resolution->value,
        );

        $this->assertFalse(
            $identicon->sizeNonStrict,
        );
    }

    public function testBadSizeMultipleOf(): void {
        $binary = new Binary(
            Resolution::Medium,
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            \sprintf(
                'Size must be a multiple of %d. The closest acceptable size %d',
                Resolution::Medium->value,
                $binary->getMultipleSize(126),
            ),
        );

        new Identicon(
            canvas: new CustomCanvas(),
            size: 126,
            sizeNonStrict: false,
        );
    }

    public function testBadSizeNegative(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Size cannot be negative or zero',
        );

        new Identicon(
            canvas: new CustomCanvas(),
            size: -120,
        );
    }

    public function testBadSizeZero(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Size cannot be negative or zero',
        );

        new Identicon(
            canvas: new CustomCanvas(),
            size: 0,
        );
    }

    public function testSize(): void {
        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertSame(
            self::IMAGE_SIZE,
            $identicon->size,
        );

        $identicon = new Identicon(
            canvas: new CustomCanvas(),
            size: 120,
        );

        $this->assertSame(
            120,
            $identicon->size,
        );
    }

    public function testSizeNonStrict(): void {
        $identicon = new Identicon(
            canvas: new CustomCanvas(),
            size: 126,
            sizeNonStrict: true,
        );

        $this->assertSame(
            126,
            $identicon->size,
        );

        $this->assertTrue(
            $identicon->sizeNonStrict,
        );
    }

    public function testBadSizeResolution(): void {
        $resolution = Resolution::Tiny;

        $binary = new Binary(
            $resolution,
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            \sprintf(
                'Size must be a multiple of %d. The closest acceptable size %d',
                $resolution->value,
                $binary->getMultipleSize(self::IMAGE_SIZE),
            ),
        );

        new Identicon(
            canvas: new CustomCanvas(),
            size: self::IMAGE_SIZE,
            resolution: $resolution,
            sizeNonStrict: false,
        );
    }

    public function testResolution(): void {
        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $this->assertSame(
            12,
            $identicon->resolution->value,
        );

        $identicon = new Identicon(
            canvas: new CustomCanvas(),
            size: 128,
            resolution: Resolution::Huge,
            sizeNonStrict: false,
        );

        $this->assertSame(
            16,
            $identicon->resolution->value,
        );
    }

    public function testBackgroundException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid background format');

        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $identicon->generate(
            string: 'test',
            background: 'invalid',
        );
    }

    public function testForegroundException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid foreground format');

        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $identicon->generate(
            string: 'test',
            foreground: 'invalid',
        );
    }

    public function testGenerate(): void {
        $identicon = new Identicon(
            new CustomCanvas(),
            self::IMAGE_SIZE,
        );

        $generate = $identicon->generate('test');

        $this->assertSame(
            'tmp',
            $generate->format,
        );

        $this->assertSame(
            'test response',
            $generate->output,
        );

        $this->assertSame(
            'test response',
            (string) $generate,
        );

        $generate->save(
            $file = self::TEMP_GENERATE,
        );

        $this->assertSame(
            'test response',
            file_get_contents($file),
        );
    }
}
