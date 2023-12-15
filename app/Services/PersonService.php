<?php declare(strict_types = 1);

namespace App\Services;

use App\Models\Person;

/**
 * Provides methods for retrieving and inserting {@see Person} data.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class PersonService
{
    /**
     * Fetches a person by their ID.
     *
     * @param int $id The ID of the person to fetch.
     * @return Person|null The fetched Person object, or null if no person is found.
     */
    public function fetchById(int $id): ?Person
    {
        return Person::find($id);
    }

    /**
     * Insert multiple people into the database.
     *
     * @param array<string, mixed> $people An array of People objects to insert into the database.
     * @return void
     */
    public function insertAll(array $people): void
    {
        Person::insert($people);
    }
}
