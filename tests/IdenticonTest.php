<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\{Binary, Identicon, Resolution};
use Usarise\IdenticonTests\ImageDriver\CustomDriver;

final class IdenticonTest extends TestCase {
    public function testImageSizeDefault(): void {
        $this->assertEquals(
            420,
            Identicon::IMAGE_SIZE,
        );
    }

    public function testImageSizeValid(): void {
        $this->assertTrue(
            Identicon::IMAGE_SIZE % 2 === 0,
        );
    }

    public function testImageBackgroundDefault(): void {
        $this->assertEquals(
            '#F0F0F0',
            Identicon::IMAGE_BACKGROUND,
        );
    }

    public function testCustomDriver(): void {
        $identicon = new Identicon(new CustomDriver());

        $this->assertInstanceOf(
            CustomDriver::class,
            $identicon->image,
        );
    }

    public function testResolution(): void {
        $identicon = new Identicon(new CustomDriver());

        $this->assertEquals(
            12,
            $identicon->resolution->value,
        );

        $identicon = new Identicon(
            new CustomDriver(),
            Resolution::Small,
        );

        $this->assertEquals(
            10,
            $identicon->resolution->value,
        );
    }

    public function testFillColor(): void {
        $identicon = new Identicon(new CustomDriver());
        $binary = new Binary(Resolution::Medium);

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
        );

        $identicon->generate(
            'test',
            'invalid',
        );
    }

    public function testFillException(): void {
        $this->expectException(InvalidArgumentException::class);

        $identicon = new Identicon(
            new CustomDriver(),
        );

        $identicon->generate(
            'test',
            null,
            'invalid',
        );
    }

    public function testHexColorValidation(): void {
        $identicon = new Identicon(new CustomDriver());

        $this->assertTrue(
            $identicon->hexColorValidation('#F0F0F0'),
        );

        $this->assertTrue(
            $identicon->hexColorValidation('#f2f1f2'),
        );
    }

    public function testHexColorValidationFalse(): void {
        $identicon = new Identicon(new CustomDriver());

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
