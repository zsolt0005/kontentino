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
final class GetNullablePropertyValueTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array<string, string[]>
     */
    public static function provideTestCaseData(): array
    {
        return [
            'Integer' => [150, 150],
            'Boolean' => [true, true],
            'Clean String' => ['Hello', 'Hello'],
            'unknown' => ['unknown', null],
            'n/a' => ['n/a', null],
            'none' => ['none', null],
            '?' => ['?', null],
        ];
    }

    /**
     * Test case.
     *
     * @param mixed $input
     * @param mixed $expectedOutput
     *
     * @return void
     * @throws Exception
     *
     * @dataProvider provideTestCaseData
     * @covers \App\Console\Commands\SyncCommand::getNullablePropertyValue
     * @covers \App\Console\Commands\SyncCommand::normalizePropertyValue
     */
    public function testCase(mixed $input, mixed $expectedOutput): void
    {
        $reflectionClass = new ReflectionClass(SyncCommand::class);
        $reflectionMethod = $reflectionClass->getMethod('getNullablePropertyValue');
        $reflectionMethod->setAccessible(true);

        $command = Mockery::mock(SyncCommand::class);

        $output = $reflectionMethod->invoke($command, $input);

        self::assertSame($expectedOutput, $output);
    }
}
