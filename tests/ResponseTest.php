<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use Usarise\Identicon\Exception\{InvalidArgumentException, RuntimeException};
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

        $this->assertNull(
            $response->image,
        );
    }

    public function testSaveInvalidArgumentException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('File extension must be "tmp"');

        $response = new Response(
            'tmp',
            'text/plain',
            'test write',
        );

        $response->save(
            self::TEMP_DIR . '/response.save',
        );
    }

    public function testSaveValueError(): void {
        $this->expectException(\ValueError::class);

        $response = new Response(
            '',
            'text/plain',
            'test write',
        );

        $response->save('');
    }

    public function testSaveRuntimeException(): void {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed write image to file');

        $response = new Response(
            '',
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
