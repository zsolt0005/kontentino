<?php declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Logbook;
use App\Models\Person;
use App\Models\Planet;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Planet::create([
            Planet::NAME => 'TestPlanet',
            Planet::CREATED_AT => '2023-12-17',
            Planet::EDITED_AT => '2023-12-17'
        ]);

        Person::create([
            Person::NAME => 'TestPerson',
            Person::HAIR_COLOR => 'blue',
            Person::SKIN_COLOR => 'green',
            Person::EYE_COLOR => 'red',
            Person::GENDER => 'male',
            Person::HOMEWORLD_ID => 1,
            Person::CREATED_AT => '2023-12-17',
            Person::EDITED_AT => '2023-12-17'
        ]);

        Logbook::create([
            Logbook::PERSON_ID => 1,
            Logbook::PLANET_ID => 1,
            Logbook::LATITUDE => 10.123456,
            Logbook::LONGITUDE => 20.987654,
            Logbook::SEVERITY => 1,
            Logbook::NOTE => 'Hello World',
            Logbook::CREATED_AT => '2023-12-17 17:00:00'
        ]);
    }
}
