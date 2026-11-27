<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withCache(
        cacheDirectory: __DIR__ . '/var/cache/rector',
    )
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        phpunitNarrowAsserts: true,
        phpunitMockToStub: true,
    )
    ->withAttributesSets(
        phpunit: true,
    )
    ->withPhpSets()
    ->withRootFiles()
;
