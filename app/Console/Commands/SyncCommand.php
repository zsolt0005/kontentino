<?php

namespace App\Console\Commands;

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
        $this->syncPlanets();
        $this->syncPeople();
    }

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

    private function syncPeople(): void
    {
        $page = 1;

        $allResidents = [];

        while (true)
        {
            try
            {
                $residents = $this->swapiService->fetchPeopleByPage($page);
            }
            catch (GuzzleException $e)
            {
                $this->error('Something went wrong while retrieving residents for page ' . $page . '. HTTP Error code: ' . $e->getCode());
                return;
            }

            if(!isset($residents['results']))
            {
                $this->error('Missing results field in the response.');
                return;
            }

            // TODO

            if($residents['next'] !== null)
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
        return $value !== 'unknown' ? $value : null;
    }
}
