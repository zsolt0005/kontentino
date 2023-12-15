<?php declare(strict_types = 1);

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a person entity.
 *
 * @package App\Models
 * @author  Zsolt Döme
 * @since   2023
 */
final class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    public const NAME = 'name';
    public const HEIGHT = 'height';
    public const MASS = 'mass';
    public const HAIR_COLOR = 'hair_color';
    public const SKIN_COLOR = 'skin_color';
    public const EYE_COLOR = 'eye_color';
    public const BIRTH_YEAR = 'birth_year';
    public const GENDER = 'gender';
    public const HOMEWORLD_ID = 'homeworld_id';
    public const CREATED_AT = 'created_at';
    public const EDITED_AT = 'edited_at';

    protected $fillable = [
        self::NAME,
        self::HEIGHT,
        self::MASS,
        self::HAIR_COLOR,
        self::SKIN_COLOR,
        self::EYE_COLOR,
        self::BIRTH_YEAR,
        self::GENDER,
        self::HOMEWORLD_ID,
        self::CREATED_AT,
        self::EDITED_AT
    ];

    public $timestamps = false;

    public function homeworld(): BelongsTo
    {
        return $this->belongsTo(Planet::class, self::HOMEWORLD_ID);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getMass(): ?int
    {
        return $this->mass;
    }

    public function getHairColor(): string
    {
        return $this->hair_color;
    }

    public function getSkinColor(): string
    {
        return $this->skin_color;
    }

    public function getEyeColor(): string
    {
        return $this->eye_color;
    }

    public function getBirthYear(): ?string
    {
        return $this->birth_year;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getHomeworld(): ?Planet
    {
        return $this->homeworld;
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

    public function setHeight(?int $height): self
    {
        if($this->height !== $height)
        {
            $this->height = $height;
        }

        return $this;
    }

    public function setMass(?int $mass): self
    {
        if($this->mass !== $mass)
        {
            $this->mass = $mass;
        }

        return $this;
    }

    public function setHairColor(string $hairColor): self
    {
        if($this->hair_color !== $hairColor)
        {
            $this->hair_color = $hairColor;
        }

        return $this;
    }

    public function setSkinColor(string $skinColor): self
    {
        if($this->skin_color !== $skinColor)
        {
            $this->skin_color = $skinColor;
        }

        return $this;
    }

    public function setEyeColor(string $eyeColor): self
    {
        if($this->eye_color !== $eyeColor)
        {
            $this->eye_color = $eyeColor;
        }

        return $this;
    }

    public function setBirthYear(?string $birthYear): self
    {
        if($this->birth_year !== $birthYear)
        {
            $this->birth_year = $birthYear;
        }

        return $this;
    }

    public function setGender(?Gender $gender): self
    {
        if($this->gender !== $gender?->value)
        {
            $this->gender = $gender?->value;
        }

        return $this;
    }

    public function setHomeworld(Planet $homeworld): self
    {
        if($this->homeworld !== $homeworld)
        {
            $this->homeworld()->associate($homeworld);
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
