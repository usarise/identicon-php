<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Color;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Color\Color;
use Usarise\Identicon\Exception\InvalidArgumentException;
use Usarise\Identicon\{Binary, Resolution};

final class ColorTest extends TestCase {
    public function testDefaultBackground(): void {
        $this->assertEquals(
            '#F0F0F0',
            Color::DEFAULT_BACKGROUND,
        );
    }

    public function testColorFormat(): void {
        $this->assertEquals(
            '#%02x%02x%02x',
            Color::FORMAT,
        );
    }

    public function testConstruct(): void {
        $color = new Color();

        $this->assertNull(
            $color->background,
        );
        $this->assertNull(
            $color->foreground,
        );

        $color = new Color(
            '#f2f1f2',
            '#55c878',
        );

        $this->assertEquals(
            '#f2f1f2',
            $color->background,
        );
        $this->assertEquals(
            '#55c878',
            $color->foreground,
        );
    }

    public function testBackgroundException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid background format');

        new Color(
            background: 'invalid',
        );
    }

    public function testForegroundException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid foreground format');

        new Color(
            foreground: 'invalid',
        );
    }

    public function testGenerateException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bytes array length must be a minimum of 4 elements');

        (new Color())->generate([0]);
    }

    public function testGenerate(): void {
        $color = new Color();

        $this->assertEquals(
            '#55c878',
            $color->generate(
                (new Binary(
                    Resolution::Medium,
                ))
                ->getBytes('test'),
            ),
        );
    }

    public function testFormatValidation(): void {
        $color = new Color();

        $this->assertTrue(
            $color->formatValidation('#F0F0F0'),
        );

        $this->assertTrue(
            $color->formatValidation('#f2f1f2'),
        );
    }

    public function testFormatValidationFalse(): void {
        $color = new Color();

        $this->assertFalse(
            $color->formatValidation('#000'),
        );

        $this->assertFalse(
            $color->formatValidation('#0000000'),
        );

        $this->assertFalse(
            $color->formatValidation('##FFFFF'),
        );

        $this->assertFalse(
            $color->formatValidation('FFFFFFF'),
        );

        $this->assertFalse(
            $color->formatValidation('invalid'),
        );

        $this->assertFalse(
            $color->formatValidation('#TEST00'),
        );
    }
}
