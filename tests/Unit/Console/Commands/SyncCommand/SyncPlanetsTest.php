<?php declare(strict_types=1);

namespace Console\Commands\SyncCommand;

use App\Console\Commands\SyncCommand;
use App\Data\PlanetsResponseData;
use App\Models\Planet;
use App\Services\PersonService;
use App\Services\PlanetService;
use App\Services\SwapiService;
use Exception;
use Faker\Provider\DateTime;
use Faker\Provider\Text;
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
final class SyncPlanetsTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array<string, mixed[]>
     * @throws Exception
     */
    public static function provideTestCaseData(): array
    {
        return [
            '1 - unknown' => [self::prepareResponseData('1', 'unknown'), '1', null],
            'n/a - sunny' => [self::prepareResponseData('n/a', 'sunny'), null, 'sunny'],
            '? - none' => [self::prepareResponseData('?', 'none'), null, null],
        ];
    }

    /**
     * Test case.
     *
     * @param PlanetsResponseData $responseData
     * @param string|null $expectedGravity
     * @param string|null $expectedClimate
     *
     * @return void
     * @throws Exception
     * @dataProvider provideTestCaseData
     * @covers       \App\Console\Commands\SyncCommand::syncPlanets
     * @covers       \App\Console\Commands\SyncCommand::mapPlanetResponse
     */
    public function testCase(PlanetsResponseData $responseData, ?string $expectedGravity, ?string $expectedClimate): void
    {
        $reflectionClass = new ReflectionClass(SyncCommand::class);
        $reflectionMethod = $reflectionClass->getMethod('syncPlanets');
        $reflectionMethod->setAccessible(true);

        $planetServiceMock = Mockery::mock(PlanetService::class);

        $command = new SyncCommand(
            Mockery::mock(SwapiService::class, ['fetchPlanetsByPage' => $responseData]),
            Mockery::mock(PersonService::class),
            $planetServiceMock
        );

        $planetServiceMock->expects('insertOrIgnoreAll')->andReturnUsing(
            function (array $dataToInsert) use ($expectedGravity, $expectedClimate)
            {
                self::assertSame($expectedGravity, $dataToInsert[0][Planet::GRAVITY]);
                self::assertSame($expectedClimate, $dataToInsert[0][Planet::CLIMATE]);
            }
        );
        $reflectionMethod->invoke($command);
    }

    /**
     * Prepares response data.
     *
     * @param string $gravity
     * @param string $climate
     *
     * @return PlanetsResponseData
     * @throws Exception
     */
    private static function prepareResponseData(string $gravity, string $climate): PlanetsResponseData
    {
        return new PlanetsResponseData([
            'results' => [[
                'name' => Text::randomAscii(),
                'rotation_period' => (string) Text::randomDigit(),
                'orbital_period' => (string) Text::randomDigit(),
                'diameter' => (string) Text::randomDigit(),
                'climate' => $climate,
                'gravity' => $gravity,
                'terrain' => Text::randomAscii(),
                'surface_water' => Text::randomAscii(),
                'population' => Text::randomAscii(),
                'created' => DateTime::iso8601(),
                'edited' => DateTime::iso8601(),
                'url' => '/1/',
            ]]
        ]);
    }
}
