<?php

declare(strict_types=1);

namespace Symplify\PHPStanExtensions\Tests\ErrorFormatter;

use Iterator;
use PHPStan\Testing\ErrorFormatterTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\PHPStanExtensions\ErrorFormatter\SymplifyErrorFormatter;

/**
 * @see https://github.com/phpstan/phpstan-src/blob/1.8.x/tests/PHPStan/Command/ErrorFormatter/RawErrorFormatterTest.php
 */
final class SymplifyErrorFormatterVerboseTest extends ErrorFormatterTestCase
{
    #[DataProvider('provideData')]
    public function testFormatErrors(
        string $message,
        int $expectedExitCode,
        int $numFileErrors,
        int $numGenericErrors,
        string $expectedOutputFile,
    ): void {
        $symplifyErrorFormatter = self::getContainer()->getByType(SymplifyErrorFormatter::class);

        $analysisResult = $this->getAnalysisResult($numFileErrors, $numGenericErrors);
        $output = $this->getOutput(verbose: true);
        $resultCode = $symplifyErrorFormatter->formatErrors($analysisResult, $output);

        $this->assertSame($expectedExitCode, $resultCode);

        $this->assertStringMatchesFormatFile($expectedOutputFile, str_replace("\r", "\r\n",$this->getOutputContent(verbose: true)));
    }

    /**
     * @return Iterator<mixed>
     */
    public static function provideData(): Iterator
    {
        yield ['Some message', 1, 6, 0, __DIR__ . '/Fixture/expected_single_message_many_files_report_verbose.txt'];
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../config/config.neon'];
    }
}
