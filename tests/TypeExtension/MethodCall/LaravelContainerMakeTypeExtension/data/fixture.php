<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use Symplify\PHPStanExtensions\Tests\TypeExtension\MethodCall\ContainerGetReturnTypeExtension\Source\ExternalService;
use function PHPStan\Testing\assertType;

final class SomeClass
{
    public function run(Container $container): void
    {
        $services = $container->make(ExternalService::class);
        assertType(ExternalService::class, $services);

        $services = $container->get(ExternalService::class);
        assertType(ExternalService::class, $services);
    }
}
