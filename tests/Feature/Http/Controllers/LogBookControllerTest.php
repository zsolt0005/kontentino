<?php declare(strict_types=1);

namespace Http\Controllers;

use App\Models\Logbook;
use App\Models\Person;
use App\Models\Planet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

/**
 * Class LogBookControllerTest
 *
 * @package Http\Controllers
 * @author  Zsolt Döme
 * @since   2023
 */
final class LogBookControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @var bool Whether after migration should seed too. */
    protected bool $seed = true;

    /**
     * Data provider.
     *
     * @return array[]
     */
    public static function provideTestCreateLogbookValidationFailedData(): array
    {
        return [
            ['Missing required property personId', []],
            ['Missing required property planetId', ['personId' => 1]],
            ['Missing required property latitude', ['personId' => 1, 'planetId' => 1]],
            ['Missing required property longitude', ['personId' => 1, 'planetId' => 1, 'latitude' => 10.123456]],
            ['Missing required property severity', ['personId' => 1, 'planetId' => 1, 'latitude' => 10.123456, 'longitude' => 10.123456]],
            ['Missing required property note', ['personId' => 1, 'planetId' => 1, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1]],
            ['Invalid property value 0 for property personId', ['personId' => 0, 'planetId' => 0, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1, 'note' => 'Hello']],
            ['Invalid property value 0 for property planetId', ['personId' => 1, 'planetId' => 0, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1, 'note' => 'Hello']],
            ['Person with id 2 does not exists', ['personId' => 2, 'planetId' => 2, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1, 'note' => 'Hello']],
            ['Planet with id 2 does not exists', ['personId' => 1, 'planetId' => 2, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1, 'note' => 'Hello']],
        ];
    }

    /**
     * Test case.
     *
     * @param string $exceptionMessage
     * @param array $postData
     *
     * @return void
     * @dataProvider provideTestCreateLogbookValidationFailedData
     */
    public function testCreateLogbookValidationFailed(string $exceptionMessage, array $postData): void
    {
        $response = $this->call('post', '/logbook', content: json_encode($postData));

        self::assertTrue($response->exception instanceof HttpException);
        self::assertSame($response->exception->getMessage(), $exceptionMessage);

        $response->assertStatus(400);
    }

    /**
     * Test case.
     *
     * @return void
     */
    public function testCreateLogbook(): void
    {
        $input = ['personId' => 1, 'planetId' => 1, 'latitude' => 10.123456, 'longitude' => 10.123456, 'severity' => 1, 'note' => 'Hello'];
        $response = $this->call('post', '/logbook', content: json_encode($input));

        $response->assertStatus(201);
    }

    /**
     * Test case.
     *
     * @return void
     */
    public function testGetLogbookExists(): void
    {
        $response = $this->get('/logbook/1');

        $response->assertStatus(200);
    }

    /**
     * Test case.
     *
     * @return void
     */
    public function testGetLogbookDoesntExists(): void
    {
        $response = $this->get('/logbook/10');

        $response->assertStatus(404);
    }
}
