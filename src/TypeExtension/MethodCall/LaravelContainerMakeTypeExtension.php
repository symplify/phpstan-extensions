<?php

declare(strict_types=1);

namespace Symplify\PHPStanExtensions\TypeExtension\MethodCall;

use Illuminate\Container\Container;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use Symplify\PHPStanExtensions\TypeResolver\ClassConstFetchReturnTypeResolver;

/**
 * Helps to check Container->make() return type
 */
final class LaravelContainerMakeTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @readonly
     */
    private ClassConstFetchReturnTypeResolver $classConstFetchReturnTypeResolver;

    public function __construct(ClassConstFetchReturnTypeResolver $classConstFetchReturnTypeResolver)
    {
        $this->classConstFetchReturnTypeResolver = $classConstFetchReturnTypeResolver;
    }

    public function getClass(): string
    {
        return Container::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return in_array($methodReflection->getName(), ['make', 'get'], true);
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): ?Type {
        return $this->classConstFetchReturnTypeResolver->resolve($methodReflection, $methodCall);
    }
}
