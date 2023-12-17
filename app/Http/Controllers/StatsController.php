<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Planet;
use App\Models\PlanetToTerrain;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

/**
 * Stats controller.
 *
 * @package App\Http\Controllers
 * @author  Zsolt Döme
 * @since   2023
 */
final class StatsController extends Controller
{
    /**
     * Get 10 Biggest planets.
     *
     * @return JsonResponse
     */
    public function tenBiggestPlanets(): JsonResponse
    {
        $planets = $this->getTenBiggestPlanets();

        return response()->json(
            array_map(static fn(Planet $planet) => [$planet->getName() => $planet->getDiameter() . ' km'], $planets->all())
        );
    }

    /**
     * Get terrain distributions.
     *
     * @return JsonResponse
     */
    public function terrainDistributions(): JsonResponse
    {
        return response()->json($this->getTerrainDistributions());
    }

    /**
     * Retrieves the ten biggest planets.
     *
     * @return Collection<int, Planet>
     */
    private function getTenBiggestPlanets(): Collection
    {
        return Planet::query()->orderBy(Planet::DIAMETER, 'desc')->limit(10)->get();
    }

    /**
     * Gets the terrains distributions across all planets.
     *
     * @return array<string, float>
     */
    private function getTerrainDistributions(): array
    {
        /** @var array<array<string, string|float>> $distributions */
        $distributions = PlanetToTerrain::query()
            ->select(PlanetToTerrain::TABLE . '.' . PlanetToTerrain::TERRAIN_TYPE)
            ->selectRaw('COUNT(*) / (SELECT COUNT(*) FROM ' . Planet::TABLE . ') * 100 as percentage')
            ->join(Planet::TABLE, Planet::TABLE . '.' . Planet::ID, '=', PlanetToTerrain::TABLE . '.' . PlanetToTerrain::PLANET_ID)
            ->groupBy(PlanetToTerrain::TABLE . '.' . PlanetToTerrain::TERRAIN_TYPE)
            ->orderByDesc('percentage')
            ->get()
            ->toArray();

        $distributionsMap = array_map(static fn(array $distribution) => [(string) $distribution[PlanetToTerrain::TERRAIN_TYPE] => (float) $distribution['percentage']], $distributions);

        return array_merge(...$distributionsMap);
    }
}
