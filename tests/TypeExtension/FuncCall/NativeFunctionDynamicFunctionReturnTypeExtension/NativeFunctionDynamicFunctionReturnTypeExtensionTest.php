<?php

declare(strict_types=1);

namespace Symplify\PHPStanExtensions\Tests\TypeExtension\FuncCall\NativeFunctionDynamicFunctionReturnTypeExtension;

use PHPStan\Testing\TypeInferenceTestCase;

final class NativeFunctionDynamicFunctionReturnTypeExtensionTest extends TypeInferenceTestCase
{
    public function testAsserts(): void
    {
        foreach ($this->gatherAssertTypes(__DIR__ . '/data/fixture.php') as [$assertType, $file, $expectedType, $actualType, $line]) {
            $this->assertFileAsserts($assertType, $file, ...[$expectedType, $actualType, $line]);
        }
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/config.neon'];
    }
}
