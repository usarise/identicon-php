<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use Usarise\Identicon\Exception\RuntimeException;
use Usarise\Identicon\Response;

final class ResponseTest extends IdenticonTestCase {
    public function testBase(): void {
        $response = new Response(
            'format',
            'mimeType',
            'output',
        );

        $this->assertEquals(
            'format',
            $response->format,
        );

        $this->assertEquals(
            'mimeType',
            $response->mimeType,
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

    public function testSaveValueError(): void {
        $this->expectException(\ValueError::class);

        $response = new Response(
            'tmp',
            'text/plain',
            'test write',
        );

        $response->save('');
    }

    public function testSaveException(): void {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed write image to file');

        $response = new Response(
            'tmp',
            'text/plain',
            'test write',
        );

        $response->save(
            self::TEMP_DIR,
        );
    }

    public function testSave(): void {
        $response = new Response(
            'tmp',
            'text/plain',
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
