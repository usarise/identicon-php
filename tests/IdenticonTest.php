<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\{Identicon, Resolution};
use Usarise\IdenticonTests\ImageDriver\CustomDriver;

final class IdenticonTest extends IdenticonTestCase {
    /**
     * @var int
     */
    private const IMAGE_SIZE = 420;

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
        $this->expectExceptionMessage(
            sprintf(
                'Size must be a multiple of %s',
                Resolution::Medium->value,
            ),
        );

        new Identicon(
            image: new CustomDriver(),
            size: 121,
        );
    }

    public function testBadSizeResolution(): void {
        $resolution = Resolution::Tiny;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Size must be a multiple of %s',
                $resolution->value,
            ),
        );

        new Identicon(
            image: new CustomDriver(),
            size: self::IMAGE_SIZE,
            resolution: $resolution,
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

    public function testBackgroundException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid background format');

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
        $this->expectExceptionMessage('Invalid fill format');

        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $identicon->generate(
            str: 'test',
            fill: 'invalid',
        );
    }

    public function testGenerate(): void {
        $identicon = new Identicon(
            new CustomDriver(),
            self::IMAGE_SIZE,
        );

        $generate = $identicon->generate('test');

        $this->assertEquals(
            'tmp',
            $generate->format,
        );

        $this->assertEquals(
            'test response',
            $generate->output,
        );

        $this->assertEquals(
            'test response',
            (string) $generate,
        );

        $generate->save(
            $file = self::TEMP_GENERATE,
        );

        $this->assertEquals(
            file_get_contents($file),
            'test response',
        );
    }
}
