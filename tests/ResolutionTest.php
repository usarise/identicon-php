<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;
use Usarise\Identicon\Resolution;

final class ResolutionTest extends TestCase {
    public function testResolutionValue(): void {
        $this->assertSame(
            8,
            Resolution::Tiny->value,
        );

        $this->assertSame(
            10,
            Resolution::Small->value,
        );

        $this->assertSame(
            12,
            Resolution::Medium->value,
        );

        $this->assertSame(
            14,
            Resolution::Large->value,
        );

        $this->assertSame(
            16,
            Resolution::Huge->value,
        );
    }
}
