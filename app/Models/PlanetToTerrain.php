<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a relation between a {@see Planet} and a terrain type.
 *
 * @package App\Models
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetToTerrain extends Model
{
    use HasFactory;

    /** @var string The name of the table. */
    public const TABLE = 'planet_to_terrain';

    /** @var string The name of the "planet_id" column. */
    public const PLANET_ID = 'planet_id';

    /** @var string The name of the "terrain_type" column. */
    public const TERRAIN_TYPE = 'terrain_type';

    /** @inheritDoc  */
    protected $table = self::TABLE;

    /** @inheritDoc  */
    protected $fillable = [self::PLANET_ID, self::TERRAIN_TYPE];

    /** @inheritDoc  */
    public $timestamps = false;

    /**
     * @return BelongsTo<Planet, PlanetToTerrain>
     */
    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class, self::PLANET_ID);
    }

    /**
     * Gets: The planet.
     *
     * @return Planet|null
     */
    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    /**
     * Gets: Terrain type.
     *
     * @return string
     */
    public function getTerrainType(): string
    {
        return $this->terrain_type;
    }

    /**
     * Sets: The planet.
     *
     * @param Planet $planet
     *
     * @return self
     */
    public function setHomeWorld(Planet $planet): self
    {
        if($this->planet !== $planet)
        {
            $this->planet()->associate($planet);
        }

        return $this;
    }

    /**
     * Sets: Terrain type.
     *
     * @param string $terrainType
     *
     * @return self
     */
    public function setTerrainType(string $terrainType): self
    {
        if($this->terrain_type !== $terrainType)
        {
            $this->terrain_type = $terrainType;
        }

        return $this;
    }
}
