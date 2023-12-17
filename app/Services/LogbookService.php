<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Logbook;

/**
 * Provides methods for retrieving and inserting {@see Logbook} data.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class LogbookService
{
    /**
     * Fetches a {@see Logbook} by its ID.
     *
     * @param int $id
     * @return Logbook|null
     */
    public function fetchById(int $id): ?Logbook
    {
        return Logbook::find($id);
    }
}
