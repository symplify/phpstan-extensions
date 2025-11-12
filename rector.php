<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withPreparedSets(deadCode: true, codeQuality: true, codingStyle: true, privatization: true, naming: true, earlyReturn: true)
    ->withRootFiles()
    ->withSkip([
        '*/Source/*',
        '*/Fixture/*',
    ]);
