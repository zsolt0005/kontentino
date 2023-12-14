<?php

namespace App\Services;

use App\Models\PlanetToPerson;

class PlanetToPersonService
{
    /**
     * Creates a new instance of PlanetToPerson.
     *
     * @return PlanetToPerson A new instance of PlanetToPerson.
     */
    public function create(): PlanetToPerson
    {
        return new PlanetToPerson();
    }
}
