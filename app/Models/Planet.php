<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a planet entity.
 *
 * @package App\Models
 * @author  Zsolt Döme
 * @since   2023
 */
final class Planet extends Model
{
    use HasFactory;

    /** @var string The name of the table. */
    public const TABLE = 'planets';

    /** @var string The name of the "id" column. */
    public const ID = 'id';

    /** @var string The name of the "name" column. */
    public const NAME = 'name';

    /** @var string The name of the "rotation_period" column. */
    public const ROTATION_PERIOD = 'rotation_period';

    /** @var string The name of the "orbital_period" column. */
    public const ORBITAL_PERIOD = 'orbital_period';

    /** @var string The name of the "diameter" column. */
    public const DIAMETER = 'diameter';

    /** @var string The name of the "climate" column. */
    public const CLIMATE = 'climate';

    /** @var string The name of the "gravity" column. */
    public const GRAVITY = 'gravity';

    /** @var string The name of the "surface_water" column. */
    public const SURFACE_WATER = 'surface_water';

    /** @var string The name of the "population" column. */
    public const POPULATION = 'population';

    /** @inheritDoc */
    public const CREATED_AT = 'created_at';

    /** @var string The name of the "edited_at" column. */
    public const EDITED_AT = 'edited_at';

    /** @inheritDoc  */
    protected $table = self::TABLE;

    /** @inheritDoc  */
    protected $fillable = [
        self::NAME,
        self::ROTATION_PERIOD,
        self::ORBITAL_PERIOD,
        self::DIAMETER,
        self::CLIMATE,
        self::GRAVITY,
        self::SURFACE_WATER,
        self::POPULATION,
        self::CREATED_AT,
        self::EDITED_AT
    ];

    /** @inheritDoc  */
    public $timestamps = false;

    /**
     * @return HasMany<PlanetToTerrain>
     */
    public function terrains(): HasMany
    {
        return $this->hasMany(PlanetToTerrain::class, PlanetToTerrain::PLANET_ID);
    }

    /**
     * Gets: the ID of the planet.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets: The name of this planet.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets: The number of standard days it takes for this planet to complete a single orbit of its local star.
     *
     * @return int|null
     */
    public function getRotationPeriod(): ?int
    {
        return $this->rotation_period;
    }

    /**
     * Gets: The number of standard hours it takes for this planet to complete a single rotation on its axis.
     *
     * @return int|null
     */
    public function getOrbitalPeriod(): ?int
    {
        return $this->orbital_period;
    }

    /**
     * Gets: The diameter of this planet in kilometers.
     *
     * @return int|null
     */
    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    /**
     * Gets: The climate of this planet.
     *
     * @return string|null
     */
    public function getClimate(): ?string
    {
        return $this->climate;
    }

    /**
     * Gets: A number denoting the gravity of this planet.
     *
     * @return string|null
     */
    public function getGravity(): ?string
    {
        return $this->gravity;
    }

    /**
     * Gets: The percentage of the planet surface that is naturally occurring water or bodies of water.
     *
     * @return float|null
     */
    public function getSurfaceWater(): ?float
    {
        return $this->surface_water;
    }

    /**
     * Gets: The average population of sentient beings inhabiting this planet.
     *
     * @return int|null
     */
    public function getPopulation(): ?int
    {
        return $this->population;
    }

    /**
     * Gets: The datetime of the creation.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Gets: The datetime of the last edit.
     *
     * @return string
     */
    public function getEditedAt(): string
    {
        return $this->edited_at;
    }

    /**
     * Sets: The name of this planet.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        if($this->name !== $name)
        {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Sets: The number of standard days it takes for this planet to complete a single orbit of its local star.
     *
     * @param int|null $rotationPeriod
     * @return $this
     */
    public function setRotationPeriod(?int $rotationPeriod): self
    {
        if($this->rotation_period !== $rotationPeriod)
        {
            $this->rotation_period = $rotationPeriod;
        }

        return $this;
    }

    /**
     * Sets: The number of standard hours it takes for this planet to complete a single rotation on its axis.
     *
     * @param int|null $orbitalPeriod
     * @return $this
     */
    public function setOrbitalPeriod(?int $orbitalPeriod): self
    {
        if($this->orbital_period !== $orbitalPeriod)
        {
            $this->orbital_period = $orbitalPeriod;
        }

        return $this;
    }

    /**
     * Sets: The diameter of this planet in kilometers.
     *
     * @param int|null $diameter
     * @return $this
     */
    public function setDiameter(?int $diameter): self
    {
        if($this->diameter !== $diameter)
        {
            $this->diameter = $diameter;
        }

        return $this;
    }

    /**
     * Sets: The climate of this planet.
     *
     * @param string|null $climate
     * @return $this
     */
    public function setClimate(?string $climate): self
    {
        if($this->climate !== $climate)
        {
            $this->climate = $climate;
        }

        return $this;
    }

    /**
     * Sets: A number denoting the gravity of this planet.
     *
     * @param string|null $gravity
     * @return $this
     */
    public function setGravity(?string $gravity): self
    {
        if($this->gravity !== $gravity)
        {
            $this->gravity = $gravity;
        }

        return $this;
    }

    /**
     * Sets: The percentage of the planet surface that is naturally occurring water or bodies of water.
     *
     * @param int|null $surfaceWater
     * @return $this
     */
    public function setSurfaceWater(?int $surfaceWater): self
    {
        if($this->surface_water !== $surfaceWater)
        {
            $this->surface_water = $surfaceWater;
        }

        return $this;
    }

    /**
     * Sets: The average population of sentient beings inhabiting this planet.
     *
     * @param int|null $population
     * @return $this
     */
    public function setPopulation(?int $population): self
    {
        if($this->population !== $population)
        {
            $this->population = $population;
        }

        return $this;
    }

    /**
     * Sets: The datetime of the last edit.
     *
     * @param string $editedAt
     * @return $this
     */
    public function setEditedAt(string $editedAt): self
    {
        if($this->edited_at !== $editedAt)
        {
            $this->edited_at = $editedAt;
        }

        return $this;
    }
}
