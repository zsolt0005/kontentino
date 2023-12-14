<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Planet;
use App\Services\PersonService;
use App\Services\PlanetService;
use App\Services\PlanetToPersonService;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct(
        private readonly PlanetService $planetService,
        private readonly PersonService $personService,
        private readonly PlanetToPersonService $planetToPersonService
    )
    {
    }

    public function default(): View
    {
        /*Planet::create([
            Planet::NAME => 'Test planet',
            Planet::ROTATION_PERIOD => 10,
            Planet::ORBITAL_PERIOD => 10,
            Planet::DIAMETER => 150,
            Planet::CLIMATE => 'Bad',
            Planet::GRAVITY => 'Normal',
            Planet::TERRAIN => 'Rocks',
            Planet::SURFACE_WATER => 40,
            Planet::POPULATION => 50,
            Planet::CREATED_AT => '2014-12-09 13:50:51',
            Planet::EDITED_AT => '2014-12-20 21:17:56'
        ]);*/

        $planet = $this->planetService->fetchById(1);
        //$planet->setName('Test updated');
        //$planet->save();

        /*$person = (new Person())
            ->setName('Test name')
            ->setHeight(150)
            ->setMass(80)
            ->setHairColor('red')
            ->setSkinColor('white')
            ->setEyeColor('green')
            ->setBirthYear('2020')
            ->setGender('f')
            ->setHomeworld($planet)
            ->setCreatedAt('2022-01-01 15:00:00')
            ->setEditedAt('2022-01-01 15:00:00');

        $person->save();*/

        /** @var Person $person */
        $person = $this->personService->fetchById(1);

        $this->planetToPersonService
            ->create()
            ->setPlanet($planet)
            ->setPerson($person)
            ->save();

        dump($person);
        dump($person->getHomeworld()->getName());
        dump($planet->getId());
        dump($planet->getName());

        return view('welcome');
    }
}
