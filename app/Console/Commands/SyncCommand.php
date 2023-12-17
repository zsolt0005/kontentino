<?php declare(strict_types = 1);

namespace App\Console\Commands;

use App\Data\PersonData;
use App\Data\PlanetData;
use App\Models\Person;
use App\Models\Planet;
use App\Services\PersonService;
use App\Services\PlanetService;
use App\Services\SwapiService;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use RuntimeException;

/**
 * Command for synchronizing the list of all known {@see Planet}s and their {@see Person}s.
 *
 * @package App\Console\Commands
 * @author  Zsolt Döme
 * @since   2023
 */
final class SyncCommand extends Command
{
    /** @var string The name and signature of the console command. */
    protected $signature = 'app:sync-command';

    /** @var string The console command description. */
    protected $description = 'Sync the list of all known planets and their residents.';

    /**
     * Constructor.
     *
     * @param SwapiService $swapiService
     * @param PersonService $personService
     * @param PlanetService $planetService
     */
    public function __construct(
        private readonly SwapiService $swapiService,
        private readonly PersonService $personService,
        private readonly PlanetService $planetService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->comment('Syncing planets');
        $this->syncPlanets();
        $this->info('Successfully synced planets');

        $this->comment('Syncing people');
        $this->syncPeople();
        $this->info('Successfully synced people');
    }

    /**
     * Synchronizes planets by fetching them from the SWAPI service and inserting them into the database.
     *
     * @return void
     */
    private function syncPlanets(): void
    {
        $page = 1;
        while (true)
        {
            try
            {
                $planets = $this->swapiService->fetchPlanetsByPage($page);
            }
            catch (GuzzleException $e)
            {
                $this->error('Something went wrong while retrieving planets for page ' . $page . '. HTTP Error code: ' . $e->getCode());
                return;
            }
            catch (RuntimeException $e)
            {
                $this->error('Something went wrong while parsing the retrieved data: ' . $e->getMessage());
                return;
            }

            if(!isset($planets->results))
            {
                $this->error('Missing results field in the response.');
                return;
            }

            $planetsToInsert = array_map(fn(PlanetData $planet) => $this->mapPlanetResponse($planet), $planets->results);
            $this->planetService->insertOrIgnoreAll($planetsToInsert);

            if($planets->next !== null)
            {
                $page++;
            }
            else
            {
                break;
            }
        }
    }

    /**
     * Synchronizes people data by fetching them from the SWAPI service and inserting them into the database.
     *
     * @return void
     */
    private function syncPeople(): void
    {
        $page = 1;
        while (true)
        {
            try
            {
                $people = $this->swapiService->fetchPeopleByPage($page);
            }
            catch (GuzzleException $e)
            {
                $this->error('Something went wrong while retrieving people for page ' . $page . '. HTTP Error code: ' . $e->getCode());
                return;
            }
            catch (RuntimeException $e)
            {
                $this->error('Something went wrong while parsing the retrieved data: ' . $e->getMessage());
                return;
            }

            if(!isset($people->results))
            {
                $this->error('Missing results field in the response.');
                return;
            }

            $peopleToInsert = array_map(fn(PersonData $person) => $this->mapPeopleResponse($person), $people->results);
            $this->personService->insertOrIgnoreAll($peopleToInsert);

            if($people->next !== null)
            {
                $page++;
            }
            else
            {
                break;
            }
        }
    }

    /**
     * Maps the planet response array to an array with specific keys.
     *
     * @param PlanetData $planet The planet.
     * @return array<string, mixed> The mapped planet array with specific keys.
     *
     * @throws InvalidFormatException
     */
    private function mapPlanetResponse(PlanetData $planet): array
    {
        return [
            Planet::NAME             => $planet->name,
            Planet::ROTATION_PERIOD  => $this->getNullablePropertyValue($planet->rotationPeriod),
            Planet::ORBITAL_PERIOD   => $this->getNullablePropertyValue($planet->orbitalPeriod),
            Planet::DIAMETER         => $this->getNullablePropertyValue($planet->diameter),
            Planet::CLIMATE          => $this->getNullablePropertyValue($planet->climate),
            Planet::GRAVITY          => $this->getNullablePropertyValue($planet->gravity),
            Planet::TERRAIN          => $this->getNullablePropertyValue($planet->terrain),
            Planet::SURFACE_WATER    => $this->getNullablePropertyValue($planet->surfaceWater),
            Planet::POPULATION       => $this->getNullablePropertyValue($planet->population),
            Planet::CREATED_AT       => Carbon::parse($planet->createdAt)->format('Y-m-d H:i:s'),
            Planet::EDITED_AT        => Carbon::parse($planet->editedAt)->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Maps the person response array to an array with specific keys.
     *
     * @param PersonData $person The person.
     * @return array<string, mixed> The mapped person array with specific keys.
     *
     * @throws InvalidFormatException
     */
    private function mapPeopleResponse(PersonData $person): array
    {
        // The ids from the source are matching with the imported ones
        $planetUrlSegments = explode('/', $person->homeWorldUrl);
        $planetId = $planetUrlSegments[count($planetUrlSegments) - 2];

        return [
            Person::NAME         => $person->name,
            Person::HEIGHT       => $this->getNullablePropertyValue($person->height),
            Person::MASS         => $this->getNullablePropertyValue($this->removeNumberThousandsFormatting($person->mass)),
            Person::HAIR_COLOR   => $this->normalizePropertyValue($person->hairColor),
            Person::SKIN_COLOR   => $this->normalizePropertyValue($person->skinColor),
            Person::EYE_COLOR    => $this->normalizePropertyValue($person->eyeColor),
            Person::BIRTH_YEAR   => $this->getNullablePropertyValue($person->birthYear),
            Person::GENDER       => $this->normalizePropertyValue($person->gender),
            Person::HOMEWORLD_ID => $planetId,
            Person::CREATED_AT   => Carbon::parse($person->createdAt)->format('Y-m-d H:i:s'),
            Person::EDITED_AT    => Carbon::parse($person->editedAt)->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Returns a nullable property value.
     *
     * @template T
     *
     * @param T $value The property value to check.
     * @return T|string|null The original property value if it is not 'unknown',
     *                   or null if the property value is 'unknown'.
     */
    private function getNullablePropertyValue(mixed $value): mixed
    {
        $normalized = $this->normalizePropertyValue($value);
        return ($normalized !== 'unknown' && $normalized !== 'none')
            ? $normalized
            : null;
    }

    /**
     * Prepares the gender value.
     *
     * @template T
     *
     * @param T $value The input gender value.
     * @return T|string The prepared gender value.
     */
    private function normalizePropertyValue(mixed $value): mixed
    {
        return ($value !== 'n/a' && $value !== 'N/A' && $value !== '?') ? $value : 'none';
    }

    /**
     * Removes thousands formatting from a given number.
     *
     * @param string $number The number with thousands formatting.
     * @return string The number without thousands formatting.
     */
    private function removeNumberThousandsFormatting(string $number): string
    {
        return str_replace(',', '', $number);
    }
}
