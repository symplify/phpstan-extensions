<?php

declare(strict_types=1);

namespace Symplify\PHPStanExtensions\TypeExtension\MethodCall;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\PHPStanExtensions\TypeResolver\ClassConstFetchReturnTypeResolver;

/**
 * @inspiration https://github.com/phpstan/phpstan-symfony/blob/master/src/Type/Symfony/ServiceDynamicReturnTypeExtension.php
 *
 * @see \Symplify\PHPStanExtensions\Tests\TypeExtension\MethodCall\ContainerGetReturnTypeExtension\ContainerGetReturnTypeExtensionTest
 */
final class ContainerGetReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function __construct(
        private readonly ClassConstFetchReturnTypeResolver $classConstFetchReturnTypeResolver
    ) {
    }

    public function getClass(): string
    {
        return ContainerInterface::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'get';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): ?Type {
        return $this->classConstFetchReturnTypeResolver->resolve($methodReflection, $methodCall);
    }
}
