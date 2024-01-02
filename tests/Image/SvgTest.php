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
     * @var int
     */
    private const SIZE = 420;

    public function testConstruct(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
        );
        $this->assertEquals(
            420,
            $svg->size,
        );
        $this->assertEquals(
            '#F0F0F0',
            $svg->background,
        );

        $svg = new Svg(
            120,
            '#f2f1f2',
        );
        $this->assertEquals(
            120,
            $svg->size,
        );
        $this->assertEquals(
            '#f2f1f2',
            $svg->background,
        );
    }

    public function testImage(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/image.svg'),
            $svg->image(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/image.minimize.svg'),
            $svg->image(minimize: true),
        );
    }

    public function testDrawRectImage(): void {
        $svg = new Svg(
            self::SIZE,
            self::BACKGROUND,
        );

        $svg->drawRect(
            x: 30,
            y: 30,
            width: 30,
            height: 30,
            fill: '#55c878',
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/image.rect.svg'),
            $svg->image(),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/svg/image.rect.minimize.svg'),
            $svg->image(minimize: true),
        );
    }
}
