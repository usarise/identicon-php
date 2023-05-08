<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Resolution;

final class ResolutionTest extends TestCase {
    public function testResolutionValue(): void {
        $this->assertEquals(
            8,
            Resolution::Tiny->value,
        );

        $this->assertEquals(
            10,
            Resolution::Small->value,
        );

        $this->assertEquals(
            12,
            Resolution::Medium->value,
        );

        $this->assertEquals(
            14,
            Resolution::Large->value,
        );

        $this->assertEquals(
            16,
            Resolution::Huge->value,
        );
    }
}
