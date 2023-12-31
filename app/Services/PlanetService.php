<?php declare(strict_types = 1);

namespace App\Services;

use App\Models\Planet;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Provides methods for retrieving and inserting {@see Planet} data.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetService
{
    /**
     * Fetches a planet by its ID.
     *
     * @param int $id The ID of the planet to fetch.
     *
     * @return Planet|null The fetched planet or null if no planet is found.
     */
    public function fetchById(int $id): ?Planet
    {
        return Planet::find($id);
    }

    /**
     * Get planets pagination.
     *
     * @param positive-int $itemsPerPage
     * @param string $name
     * @param int|null $page
     *
     * @return LengthAwarePaginator<Planet>
     */
    public function paginate(int $itemsPerPage, string $name = 'page', ?int $page = null): LengthAwarePaginator
    {
        return Planet::paginate($itemsPerPage, pageName: $name, page: $page);
    }

    /**
     * Insert multiple planets into the database.
     *
     * @param array<string, mixed> $planets An array of Planet objects to insert into the database.
     *
     * @return void
     */
    public function insertOrIgnoreAll(array $planets): void
    {
        Planet::insertOrIgnore($planets);
    }

    /**
     * Retrieves: Distinct gravity values.
     *
     * @return Collection<int, scalar>
     */
    public function getDistinctGravityValues(): Collection
    {
        return Planet::select(Planet::GRAVITY)
            ->distinct()
            ->pluck(Planet::GRAVITY);
    }
}
