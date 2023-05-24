<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use Usarise\Identicon\Response;

final class ResponseTest extends IdenticonTestCase {
    public function testBase(): void {
        $response = new Response(
            'format',
            'output',
        );

        $this->assertEquals(
            'format',
            $response->format,
        );

        $this->assertEquals(
            'output',
            $response->output,
        );

        $this->assertEquals(
            'output',
            (string) $response,
        );
    }

    public function testSave(): void {
        $response = new Response(
            'tmp',
            'test write',
        );

        $response->save(
            $file = self::TEMP_RESPONSE,
        );

        $this->assertEquals(
            file_get_contents($file),
            'test write',
        );
    }
}
