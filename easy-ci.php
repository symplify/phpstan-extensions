<?php

declare(strict_types=1);

use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use Symplify\EasyCI\Config\EasyCIConfig;

return static function (EasyCIConfig $easyCIConfig): void {
    $easyCIConfig->typesToSkip([
        DynamicFunctionReturnTypeExtension::class,
        DynamicMethodReturnTypeExtension::class,
    ]);
};
