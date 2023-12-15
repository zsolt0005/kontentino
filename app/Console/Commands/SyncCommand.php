<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Models\Planet;
use App\Services\PersonService;
use App\Services\PlanetService;
use App\Services\SwapiService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

final class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the list of all known planets and their residents.';

    /**
     * Constructor.
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

            if(!isset($planets['results']))
            {
                $this->error('Missing results field in the response.');
                return;
            }

            $planetsToInsert = array_map(fn(array $planet) => $this->mapPlanetResponse($planet), $planets['results']);
            $this->planetService->insertAll($planetsToInsert);

            if($planets['next'] !== null)
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

            if(!isset($people['results']))
            {
                $this->error('Missing results field in the response.');
                return;
            }

            $peopleToInsert = array_map(fn(array $person) => $this->mapPeopleResponse($person), $people['results']);
            $this->personService->insertAll($peopleToInsert);

            if($people['next'] !== null)
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
     * @param array $planet The planet response array.
     * @return array The mapped planet array with specific keys.
     */
    private function mapPlanetResponse(array $planet): array
    {
        return [
            Planet::NAME             => $planet['name'],
            Planet::ROTATION_PERIOD  => $this->getNullablePropertyValue($planet['rotation_period']),
            Planet::ORBITAL_PERIOD   => $this->getNullablePropertyValue($planet['orbital_period']),
            Planet::DIAMETER         => $this->getNullablePropertyValue($planet['diameter']),
            Planet::CLIMATE          => $this->getNullablePropertyValue($planet['climate']),
            Planet::GRAVITY          => $this->getNullablePropertyValue($planet['gravity']),
            Planet::TERRAIN          => $this->getNullablePropertyValue($planet['terrain']),
            Planet::SURFACE_WATER    => $this->getNullablePropertyValue($planet['surface_water']),
            Planet::POPULATION       => $planet['population'] !== 'unknown' ? $planet['population'] : null,
            Planet::CREATED_AT       => Carbon::parse($planet['created'])->format('Y-m-d H:i:s'),
            Planet::EDITED_AT        => Carbon::parse($planet['edited'])->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Maps the person response array to an array with specific keys.
     *
     * @param array $person The person response array.
     * @return array The mapped person array with specific keys.
     */
    private function mapPeopleResponse(array $person): array
    {
        // The ids from the source are matching with the imported ones
        $planetUrlSegments = explode('/', $person['homeworld']);
        $planetId = $planetUrlSegments[count($planetUrlSegments) - 2];

        return [
            Person::NAME         => $person['name'],
            Person::HEIGHT       => $this->getNullablePropertyValue($person['height']),
            Person::MASS         => $this->getNullablePropertyValue($this->removeNumberThousandsFormatting($person['mass'])),
            Person::HAIR_COLOR   => $person['hair_color'],
            Person::SKIN_COLOR   => $person['skin_color'],
            Person::EYE_COLOR    => $person['eye_color'],
            Person::BIRTH_YEAR   => $this->getNullablePropertyValue($person['birth_year']),
            Person::GENDER       => $this->getNullablePropertyValue($person['gender']),
            Person::HOMEWORLD_ID => $planetId,
            Person::CREATED_AT   => Carbon::parse($person['created'])->format('Y-m-d H:i:s'),
            Person::EDITED_AT    => Carbon::parse($person['edited'])->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Returns a nullable property value.
     *
     * @template T
     *
     * @param T $value The property value to check.
     * @return T|null The original property value if it is not 'unknown',
     *                   or null if the property value is 'unknown'.
     */
    private function getNullablePropertyValue(mixed $value): mixed
    {
        return ($value !== 'unknown' && $value !== 'n/a' && $value !== '?' && $value !== 'none')
            ? $value
            : null;
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
