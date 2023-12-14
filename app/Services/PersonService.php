<?php

namespace App\Services;

use App\Models\Person;

class PersonService
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
}
