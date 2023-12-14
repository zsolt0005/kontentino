<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanetToPerson extends Model
{
    use HasFactory;

    protected $table = 'planets_to_people';

    public const PLANET_ID = 'planet_id';
    public const PERSON_ID = 'person_id';

    public $incrementing = false;

    protected $primaryKey = [
        self::PLANET_ID,
        self::PERSON_ID
    ];

    public $timestamps = false;

    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class, self::PLANET_ID);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, self::PERSON_ID);
    }

    public function getPlanet(): Planet
    {
        return $this->planet;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

    public function setPlanet(Planet $planet): self
    {
        if($this->planet !== $planet)
        {
            $this->planet()->associate($planet);
        }

        return $this;
    }

    public function setPerson(Person $person): self
    {
        if($this->person !== $person)
        {
            $this->person()->associate($person);
        }

        return $this;
    }
}
