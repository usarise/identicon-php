<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests\Image;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Image\Svg\Svg;

final class SvgTest extends TestCase {
    /**
     * @var string
     */
    public const BACKGROUND = '#F0F0F0';

    /**
     * @var string
     */
    public const FOREGROUND = '#55c878';

    /**
     * @var int
     */
    private const SIZE = 420;

    public function testConstruct(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
            self::FOREGROUND,
        );
        $this->assertEquals(
            420,
            $svg->size,
        );
        $this->assertEquals(
            '#F0F0F0',
            $svg->background,
        );
        $this->assertEquals(
            '#55c878',
            $svg->foreground,
        );

        $svg = new Svg(
            120,
            '#f2f1f2',
            '#84c7b5',
        );
        $this->assertEquals(
            120,
            $svg->size,
        );
        $this->assertEquals(
            '#f2f1f2',
            $svg->background,
        );
        $this->assertEquals(
            '#84c7b5',
            $svg->foreground,
        );
    }

    public function testGenerate(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
            self::FOREGROUND,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/generate.svg'),
            $svg->generate(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/generate.minimize.svg'),
            $svg->generate(minimize: true),
        );
    }

    public function testGenerateDrawRect(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
            self::FOREGROUND,
        );

        $svg->drawRect(
            x: 30,
            y: 30,
            width: 30,
            height: 30,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/generate.rect.svg'),
            $svg->generate(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/generate.rect.minimize.svg'),
            $svg->generate(minimize: true),
        );
    }
}
