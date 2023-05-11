<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\{Binary, Identicon, Resolution};
use Usarise\IdenticonTests\ImageDriver\CustomDriver;

final class IdenticonTest extends TestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 420;

    public function testImageBackgroundDefault(): void {
        $this->assertEquals(
            '#F0F0F0',
            Identicon::IMAGE_BACKGROUND,
        );
    }

    public function testCustomDriver(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertInstanceOf(
            CustomDriver::class,
            $identicon->image,
        );
    }

    public function testSize(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            self::IMAGE_SIZE,
            $identicon->size,
        );

        $identicon = new Identicon(
            image: new CustomDriver(),
            size: 120,
        );

        $this->assertEquals(
            120,
            $identicon->size,
        );
    }

    public function testBadSize(): void {
        $this->expectException(InvalidArgumentException::class);

        new Identicon(
            image: new CustomDriver(),
            size: 121,
        );
    }

    public function testBadSizeResolution(): void {
        $this->expectException(InvalidArgumentException::class);

        new Identicon(
            image: new CustomDriver(),
            size: self::IMAGE_SIZE,
            resolution: Resolution::Tiny,
        );
    }

    public function testResolution(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertEquals(
            12,
            $identicon->resolution->value,
        );

        $identicon = new Identicon(
            image: new CustomDriver(),
            size: 128,
            resolution: Resolution::Huge,
        );

        $this->assertEquals(
            16,
            $identicon->resolution->value,
        );
    }

    public function testFillColor(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $binary = new Binary(
            $identicon->resolution,
        );

        $this->assertEquals(
            '#55c878',
            $identicon->getFillColor(
                $binary->getBytes('test'),
            ),
        );
    }

    public function testBackgroundException(): void {
        $this->expectException(InvalidArgumentException::class);

        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $identicon->generate(
            str: 'test',
            background: 'invalid',
        );
    }

    public function testFillException(): void {
        $this->expectException(InvalidArgumentException::class);

        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $identicon->generate(
            str: 'test',
            fill: 'invalid',
        );
    }

    public function testHexColorValidation(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertTrue(
            $identicon->hexColorValidation('#F0F0F0'),
        );

        $this->assertTrue(
            $identicon->hexColorValidation('#f2f1f2'),
        );
    }

    public function testHexColorValidationFalse(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $this->assertFalse(
            $identicon->hexColorValidation('#000'),
        );

        $this->assertFalse(
            $identicon->hexColorValidation('#0000000'),
        );

        $this->assertFalse(
            $identicon->hexColorValidation('##FFFFF'),
        );

        $this->assertFalse(
            $identicon->hexColorValidation('FFFFFFF'),
        );

        $this->assertFalse(
            $identicon->hexColorValidation('invalid'),
        );

        $this->assertFalse(
            $identicon->hexColorValidation('#TEST00'),
        );
    }
}
