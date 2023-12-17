<?php declare(strict_types=1);

namespace Console\Commands\SyncCommand;

use App\Console\Commands\SyncCommand;
use App\Data\PlanetData;
use App\Data\PlanetsResponseData;
use App\Models\Planet;
use App\Services\PersonService;
use App\Services\PlanetService;
use App\Services\SwapiService;
use Exception;
use Faker\Provider\DateTime;
use Faker\Provider\Text;
use Mockery;
use ReflectionClass;
use Spatie\LaravelData\DataCollection;
use Tests\TestCase;

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
        $planetData = new PlanetData();

        $planetData->name = Text::randomAscii();
        $planetData->rotationPeriod = (string) Text::randomDigit();
        $planetData->orbitalPeriod = (string) Text::randomDigit();
        $planetData->diameter = (string) Text::randomDigit();
        $planetData->climate = $climate;
        $planetData->gravity = $gravity;
        $planetData->terrain = Text::randomAscii();
        $planetData->surfaceWater = Text::randomAscii();
        $planetData->population = Text::randomAscii();
        $planetData->createdAt = DateTime::iso8601();
        $planetData->editedAt = DateTime::iso8601();
        $planetData->url = '/1/';

        $results = Mockery::mock(DataCollection::class, [
            'items' => [$planetData]
        ]);
        $results->name = Text::randomAscii();

        $data = Mockery::mock(PlanetsResponseData::class);
        $data->next = null;
        $data->results = $results;

        return $data;
    }
}
