<?php declare(strict_types=1);

namespace App\Services;

use App\Models\PlanetToTerrain;

/**
 * Service for {@see PlanetToTerrain}.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetToTerrainService
{
    /**
     * Insert multiple {@see PlanetToTerrain} into the database.
     *
     * @param array<string, mixed> $planetsToTerrains
     *
     * @return void
     */
    public function insertOrIgnoreAll(array $planetsToTerrains): void
    {
        PlanetToTerrain::insertOrIgnore($planetsToTerrains);
    }
}
