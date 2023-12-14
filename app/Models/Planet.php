<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $table = 'planets';
    public $timestamps = false;

    public const NAME = 'name';
    public const ROTATION_PERIOD = 'rotation_period';
    public const ORBITAL_PERIOD = 'orbital_period';
    public const DIAMETER = 'diameter';
    public const CLIMATE = 'climate';
    public const GRAVITY = 'gravity';
    public const TERRAIN = 'terrain';
    public const SURFACE_WATER = 'surface_water';
    public const POPULATION = 'population';
    public const CREATED_AT = 'created_at';
    public const EDITED_AT = 'edited_at';

    protected $fillable = [
        self::NAME,
        self::ROTATION_PERIOD,
        self::ORBITAL_PERIOD,
        self::DIAMETER,
        self::CLIMATE,
        self::GRAVITY,
        self::TERRAIN,
        self::SURFACE_WATER,
        self::POPULATION,
        self::CREATED_AT,
        self::EDITED_AT
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRotationPeriod(): int
    {
        return $this->rotation_period;
    }

    public function getOrbitalPeriod(): int
    {
        return $this->orbital_period;
    }

    public function getDiameter(): int
    {
        return $this->diameter;
    }

    public function getClimate(): string
    {
        return $this->climate;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function getTerrain(): string
    {
        return $this->terrain;
    }

    public function getSurfaceWater(): float
    {
        return $this->surface_water;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getEditedAt(): string
    {
        return $this->edited_at;
    }

    public function setName(string $name): self
    {
        if($this->name !== $name)
        {
            $this->name = $name;
        }

        return $this;
    }

    public function setRotationPeriod(int $rotationPeriod): self
    {
        if($this->rotation_period !== $rotationPeriod)
        {
            $this->rotation_period = $rotationPeriod;
        }

        return $this;
    }

    public function setOrbitalPeriod(int $orbitalPeriod): self
    {
        if($this->orbital_period !== $orbitalPeriod)
        {
            $this->orbital_period = $orbitalPeriod;
        }

        return $this;
    }

    public function setDiameter(int $diameter): self
    {
        if($this->diameter !== $diameter)
        {
            $this->diameter = $diameter;
        }

        return $this;
    }

    public function setClimate(string $climate): self
    {
        if($this->climate !== $climate)
        {
            $this->climate = $climate;
        }

        return $this;
    }

    public function setGravity(string $gravity): self
    {
        if($this->gravity !== $gravity)
        {
            $this->gravity = $gravity;
        }

        return $this;
    }

    public function setTerrain(string $terrain): self
    {
        if($this->terrain !== $terrain)
        {
            $this->terrain = $terrain;
        }

        return $this;
    }

    public function setSurfaceWater(float $surfaceWater): self
    {
        if($this->surface_water !== $surfaceWater)
        {
            $this->surface_water = $surfaceWater;
        }

        return $this;
    }

    public function setPopulation(int $population): self
    {
        if($this->population !== $population)
        {
            $this->population = $population;
        }

        return $this;
    }

    public function setEditedAt(string $editedAt): self
    {
        if($this->edited_at !== $editedAt)
        {
            $this->edited_at = $editedAt;
        }

        return $this;
    }
}
