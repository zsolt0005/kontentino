<?php declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

/**
 * Logbook data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class LogbookData extends Data
{
    public ?int $personId = null;
    public ?int $planetId = null;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?int $severity = null;
    public ?string $note = null;
    public ?string $createdAt = null;
}
