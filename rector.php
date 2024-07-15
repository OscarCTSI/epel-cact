<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::PHP_80,
        SetList::PHP_81,
    ]);

    $rectorConfig->paths([
        __DIR__ . '/web/modules/custom',
    ]);
};
