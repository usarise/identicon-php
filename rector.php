<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->skip([
        NewlineAfterStatementRector::class,
        NewlineBeforeNewAssignSetRector::class,
        PostIncDecToPreIncDecRector::class => [
            __DIR__ . '/src/Binary.php',
        ],
        ChangeAndIfToEarlyReturnRector::class => [
            __DIR__ . '/src/Color/Color.php',
        ],
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
    ]);
};
