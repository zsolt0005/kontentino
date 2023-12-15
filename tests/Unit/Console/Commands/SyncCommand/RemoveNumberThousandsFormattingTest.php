<?php declare(strict_types=1);

namespace Console\Commands\SyncCommand;

use App\Console\Commands\SyncCommand;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test.
 *
 * @package Console\Commands\SyncCommand
 * @author  Zsolt Döme
 * @since   2023
 */
final class RemoveNumberThousandsFormattingTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array<string, string[]>
     */
    public static function provideTestCaseData(): array
    {
        return [
            'with ,' => ['1,123', '1123'],
            'without ,' => ['123', '123'],
            'with 2x ,' => ['1,123,123', '1123123']
        ];
    }

    /**
     * Test case.
     *
     * @param string $input
     * @param string $expectedOutput
     *
     * @return void
     * @throws Exception
     *
     * @dataProvider provideTestCaseData
     * @covers \App\Console\Commands\SyncCommand::removeNumberThousandsFormatting
     */
    public function testCase(string $input, string $expectedOutput): void
    {
        $reflectionClass = new ReflectionClass(SyncCommand::class);
        $reflectionMethod = $reflectionClass->getMethod('removeNumberThousandsFormatting');
        $reflectionMethod->setAccessible(true);

        $command = Mockery::mock(SyncCommand::class);

        $output = $reflectionMethod->invoke($command, $input);

        self::assertSame($expectedOutput, $output);
    }
}
