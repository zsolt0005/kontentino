<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Planet;
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
     * Retrieves the ten biggest planets.
     *
     * @return Collection<int, Planet>
     */
    private function getTenBiggestPlanets(): Collection
    {
        return Planet::query()->orderBy(Planet::DIAMETER, 'desc')->limit(10)->get();
    }
}
