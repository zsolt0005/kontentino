<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

/**
 * Represents a logbook entity.
 *
 * @package App\Models
 * @author  Zsolt Döme
 * @since   2023
 *
 * @property string $note
 */
final class Logbook extends Model
{
    use HasFactory;

    /** @var string The name of the table. */
    public const TABLE = 'logbook';

    /** @var string The name of the "id" column. */
    public const ID = 'id';

    /** @var string The name of the "person_id" column. */
    public const PERSON_ID = 'person_id';

    /** @var string The name of the "planet_id" column. */
    public const PLANET_ID = 'planet_id';

    /** @var string The name of the "latitude" column. */
    public const LATITUDE = 'latitude';

    /** @var string The name of the "longitude" column. */
    public const LONGITUDE = 'longitude';

    /** @var string The name of the "servity" column. */
    public const SEVERITY = 'severity';

    /** @var string The name of the "note" column. */
    public const NOTE = 'note';

    /** @var string The name of the "created_at" column. */
    public const CREATED_AT  = 'created_at';

    /** @inheritDoc  */
    protected $table = self::TABLE;

    /** @inheritDoc  */
    protected $fillable = [
        self::PERSON_ID,
        self::PLANET_ID,
        self::LATITUDE,
        self::LONGITUDE,
        self::SEVERITY,
        self::NOTE,
        self::CREATED_AT
    ];

    /** @inheritDoc  */
    public $timestamps = false;

    /**
     * @return BelongsTo<Person, Logbook>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, self::PERSON_ID);
    }

    /**
     * @return BelongsTo<Planet, Logbook>
     */
    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class, self::PLANET_ID);
    }

    /**
     * Note attribute getter and setter mutators.
     *
     * @return Attribute<string, string>
     */
    protected function note(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Crypt::decryptString($value),
            set: fn (string $value) => Crypt::encryptString($value),
        );
    }

    /**
     * Gets: the ID of the logbook.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets: The person that created the log entry.
     *
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * Gets: The planet where the log was created at.
     *
     * @return Planet|null
     */
    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    /**
     * Gets: GPS Location: latitude.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Gets: GPS Location: longitude.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Gets: Severity of the note. Higher number = greater severity.
     *
     * @return int
     */
    public function getSeverity(): int
    {
        return $this->severity;
    }

    /**
     * Gets: Note.
     *
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * Gets: Creation date time of the log
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Sets: The person that created the log entry.
     *
     * @param Person $person
     * @return self
     */
    public function setPerson(Person $person): self
    {
        if($this->person !== $person)
        {
            $this->person()->associate($person);
        }

        return $this;
    }

    /**
     * Sets: The planet where the log was created at.
     *
     * @param Planet $planet
     * @return self
     */
    public function setPlanet(Planet $planet): self
    {
        if($this->planet !== $planet)
        {
            $this->planet()->associate($planet);
        }

        return $this;
    }

    /**
     * Sets: GPS Location: latitude.
     *
     * @param float $latitude
     * @return self
     */
    public function setLatitude(float $latitude): self
    {
        if($this->latitude !== $latitude)
        {
            $this->latitude = $latitude;
        }

        return $this;
    }

    /**
     * Sets: GPS Location: longitude.
     *
     * @param float $longitude
     * @return self
     */
    public function setLongitude(float $longitude): self
    {
        if($this->longitude !== $longitude)
        {
            $this->longitude = $longitude;
        }

        return $this;
    }

    /**
     * Sets: Severity of the note. Higher number = greater severity
     *
     * @param int $severity
     * @return self
     */
    public function setSeverity(int $severity): self
    {
        if($this->severity !== $severity)
        {
            $this->severity = $severity;
        }

        return $this;
    }

    /**
     * Sets: Note.
     *
     * @param string $note
     * @return self
     */
    public function setNote(string $note): self
    {
        if($this->note !== $note)
        {
            $this->note = $note;
        }

        return $this;
    }
}
