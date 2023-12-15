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

    /** @inheritDoc  */
    protected $table = 'people';

    /** @var string The name of the "name" column. */
    public const NAME = 'name';

    /** @var string The name of the "height" column. */
    public const HEIGHT = 'height';

    /** @var string The name of the "mass" column. */
    public const MASS = 'mass';

    /** @var string The name of the "hair_color" column. */
    public const HAIR_COLOR = 'hair_color';

    /** @var string The name of the "skin_color" column. */
    public const SKIN_COLOR = 'skin_color';

    /** @var string The name of the "eye_color" column. */
    public const EYE_COLOR = 'eye_color';

    /** @var string The name of the "birth_year" column. */
    public const BIRTH_YEAR = 'birth_year';

    /** @var string The name of the "gender" column. */
    public const GENDER = 'gender';

    /** @var string The name of the "homeworld_id" column. */
    public const HOMEWORLD_ID = 'homeworld_id';

    /** @inheritDoc  */
    public const CREATED_AT = 'created_at';

    /** @var string The name of the "edited_at" column. */
    public const EDITED_AT = 'edited_at';

    /** @inheritDoc  */
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

    /** @inheritDoc  */
    public $timestamps = false;

    public function homeworld(): BelongsTo
    {
        return $this->belongsTo(Planet::class, self::HOMEWORLD_ID);
    }

    /**
     * Gets: the ID of the Person.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets: The name of this person.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets: The height of the person in centimeters.
     *
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * Gets: The mass of the person in kilograms.
     *
     * @return int|null
     */
    public function getMass(): ?int
    {
        return $this->mass;
    }

    /**
     * Gets: The hair color of this person. Will be "unknown" if not known or "n/a" if the person does not have hair.
     *
     * @return string
     */
    public function getHairColor(): string
    {
        return $this->hair_color;
    }

    /**
     * Gets: The skin color of this person.
     *
     * @return string
     */
    public function getSkinColor(): string
    {
        return $this->skin_color;
    }

    /**
     * Gets: The eye color of this person. Will be "unknown" if not known or "n/a" if the person does not have an eye
     *
     * @return string
     */
    public function getEyeColor(): string
    {
        return $this->eye_color;
    }

    /**
     * Gets: The birth year of the person, using the in-universe standard of BBY or ABY - Before the Battle of Yavin or After the Battle of Yavin.
     *
     * @return string|null
     */
    public function getBirthYear(): ?string
    {
        return $this->birth_year;
    }

    /**
     * Gets: The gender of this person. Either "Male", "Female", "hermaphrodite" or "unknown", "n/a" if the person does not have a gender.
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * Gets: The planet that this person was born on or inhabits.
     *
     * @return Planet|null
     */
    public function getHomeWorld(): ?Planet
    {
        return $this->homeworld;
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
     * Sets: The name of this person.
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
     * Sets: The height of the person in centimeters.
     *
     * @param int|null $height
     * @return $this
     */
    public function setHeight(?int $height): self
    {
        if($this->height !== $height)
        {
            $this->height = $height;
        }

        return $this;
    }

    /**
     * Sets: The mass of the person in kilograms.
     *
     * @param int|null $mass
     * @return $this
     */
    public function setMass(?int $mass): self
    {
        if($this->mass !== $mass)
        {
            $this->mass = $mass;
        }

        return $this;
    }

    /**
     * Sets: The hair color of this person. Will be "unknown" if not known or "n/a" if the person does not have hair.
     *
     * @param string $hairColor
     * @return $this
     */
    public function setHairColor(string $hairColor): self
    {
        if($this->hair_color !== $hairColor)
        {
            $this->hair_color = $hairColor;
        }

        return $this;
    }

    /**
     * Sets: The skin color of this person.
     *
     * @param string $skinColor
     * @return $this
     */
    public function setSkinColor(string $skinColor): self
    {
        if($this->skin_color !== $skinColor)
        {
            $this->skin_color = $skinColor;
        }

        return $this;
    }

    /**
     * Sets: The eye color of this person. Will be "unknown" if not known or "n/a" if the person does not have an eye
     *
     * @param string $eyeColor
     * @return $this
     */
    public function setEyeColor(string $eyeColor): self
    {
        if($this->eye_color !== $eyeColor)
        {
            $this->eye_color = $eyeColor;
        }

        return $this;
    }

    /**
     * Sets: The birth year of the person, using the in-universe standard of BBY or ABY - Before the Battle of Yavin or After the Battle of Yavin.
     *
     * @param string|null $birthYear
     * @return $this
     */
    public function setBirthYear(?string $birthYear): self
    {
        if($this->birth_year !== $birthYear)
        {
            $this->birth_year = $birthYear;
        }

        return $this;
    }

    /**
     * Sets: The gender of this person. Either "Male", "Female", "hermaphrodite" or "unknown", "n/a" if the person does not have a gender.
     *
     * @param Gender $gender
     * @return $this
     */
    public function setGender(Gender $gender): self
    {
        if($this->gender !== $gender->value)
        {
            $this->gender = $gender->value;
        }

        return $this;
    }

    /**
     * Sets: The planet that this person was born on or inhabits.
     *
     * @param Planet $homeWorld
     * @return $this
     */
    public function setHomeWorld(Planet $homeWorld): self
    {
        if($this->homeworld !== $homeWorld)
        {
            $this->homeworld()->associate($homeWorld);
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
