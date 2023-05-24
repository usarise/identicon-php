<?php

declare(strict_types=1);

namespace Usarise\IdenticonTests;

use PHPUnit\Framework\TestCase;

abstract class IdenticonTestCase extends TestCase {
    /**
     * @var string
     */
    protected const TEMP_DIR = __DIR__ . '/tmp';

    /**
     * @var string
     */
    protected const TEMP_GENERATE = self::TEMP_DIR . '/generate.tmp';

    /**
     * @var string
     */
    protected const TEMP_RESPONSE = self::TEMP_DIR . '/response.tmp';

    protected function setUp(): void {
        if (!is_dir($tmp = self::TEMP_DIR)) {
            mkdir($tmp, 0o777, true);
        }
    }

    protected function tearDown(): void {
        if (is_file($file = self::TEMP_GENERATE)) {
            unlink($file);
        }

        if (is_file($file = self::TEMP_RESPONSE)) {
            unlink($file);
        }

        if (is_dir($tmp = self::TEMP_DIR)) {
            rmdir($tmp);
        }
    }
}
