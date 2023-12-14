<?php

namespace App\Services;

use App\Models\Planet;

final class PlanetService
{
    /**
     * Fetches a planet by its ID.
     *
     * @param int $id The ID of the planet to fetch.
     * @return Planet|null The fetched planet or null if no planet is found.
     */
    public function fetchById(int $id): ?Planet
    {
        return Planet::find($id);
    }

    /**
     * Insert multiple planets into the database.
     *
     * @param array $planets An array of Planet objects to insert into the database.
     * @return void
     */
    public function insertAll(array $planets): void
    {
        Planet::insert($planets);
    }
}
